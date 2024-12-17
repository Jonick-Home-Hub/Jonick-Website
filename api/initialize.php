<?php

    ob_start(); // Turning on output buffering
    require_once('src/credentials.php');//defined database credentials
    require_once('src/db_functions.php');//defined database functions
    require_once('src/validation_functions.php');//defined database functions
    require_once('src/jwt_function.php');//defined jwt functions

    // Load all classes in the directory
    foreach (glob('classes/*.class.php') as $model) {
        include_once($model);
    }

    //Autoload Class Definitions
    function my_autoload($class)
    {
        if (preg_match('/\A\w+\Z/',$class)) {
            $file_name = __DIR__ . '/';
            $file_name .= 'classes/'.$class.'.class.php';
            if(file_exists($file_name)){
                include($file_name);
            }
        }
    }
    spl_autoload_register('my_autoload');
    $database= db_connect();
    databaseobject::setDatabase($database);
    

?>