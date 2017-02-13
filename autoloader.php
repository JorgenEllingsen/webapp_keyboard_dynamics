<?php
spl_autoload_register(function($class_name) {

    $class_name = str_replace('\\', '/', $class_name);
    if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.$class_name.'.php')) {
        require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.$class_name.'.php');
        return;
    }
    else {
        die('Class not found in '.dirname(__FILE__).DIRECTORY_SEPARATOR.$class_name.'.php (Autoloader)');
    }
});