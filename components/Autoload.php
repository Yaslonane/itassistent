<?php

/* 
 * 
 */

function __autoload($class_name){
    
    $array_path = array(
        '/models/',
        '/controllers/',
        '/components/'
    );
    
    foreach ($array_path as $path){
        $path = ROOT . $path . $class_name . '.php';
        if (is_file($path)){
            include_once $path;
        }
    }
}
