<?php
/**
 * Explanation
 */

set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext){
    /*
     * Оказывается, что есть пятый параметр: $errcontext; Он содержит все переменные текущей области видимости
     * включая и предшествующий $e из catch
     */
    //если посмотреть на него, то он будет расти с каждым вызовом error_handler'а
    strlen(print_r($errcontext, true));

    /**
     * Эксепшн содержит бэктрейс, содержащий все аргументы, переданные error_handler'у
     * вк
     */

    throw new Exception($errstr);
});

function leak($i = 10) {
    while ($i-- > 0) {
        try {
            1 / 0; //leaks
        } catch (Exception $e) {
            /*
             * Если после обработки эксепшена мы очистим $e, то его и не будет в контексте для обработчика
             * и ничего не будет расти
             */
            //unset($e);//problem solving
        }
        echo memory_get_usage(), PHP_EOL;
    }
}

leak();