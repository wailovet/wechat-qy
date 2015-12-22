<?php
spl_autoload_register(function ($class) {

    if (false !== stripos($class, 'Wailovet\\')) {
        require_once __DIR__.'/src/'.str_replace("\\",DIRECTORY_SEPARATOR,str_replace('\\wechat\\', DIRECTORY_SEPARATOR, substr($class, 8))).'.php';
    }
});
