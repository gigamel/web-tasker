<?php
spl_autoload_register(function($class) {
    $baseDir = __DIR__;

    $class = ltrim($class, '\\');

    $classFile = $baseDir . '/' . str_replace('\\', '/', $class) . '.php';
    
    file_exists($classFile) or die("file: <b>{$classFile}</b> does not exists.");
    
    require_once $classFile;

    class_exists($class) or die("class: <b>{$class}</b> does not exists.");
});