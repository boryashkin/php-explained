<?php
/**
 * Introduction
 *
 * https://bugs.php.net/bug.php?id=53228
 * В данном репорте утверждается, что пхп течет по памяти, когда вызываешь ошибку
 * а в ней бросаешь исключение и его перехватываешь (это проявляется в демонах)
 */

set_error_handler(function($errno, $errstr, $errfile, $errline){
    throw new Exception($errstr);
});

function leak($i = 10) {
    while ($i-- > 0) {
        try {
            1 / 0; //leaks
        } catch (Exception $e) {}
        echo memory_get_usage(), PHP_EOL;
    }
}

leak();