<?php
require('config.php');
require('db.php');
require('http.php');

/**
 * Autoloads a class file based on the class name.
 *
 * @param string $className The fully qualified class name.
 * @return void
 */
function customAutoloader(string $className): void
{
    $baseDir = __DIR__ . '/methods/';
    $classFile = $baseDir . str_replace('\\', '/', $className) . '.php';

    if (file_exists($classFile)) {
        require_once $classFile;
    }
}

// Register the custom autoloader function
spl_autoload_register('customAutoloader');

require('bot.php');
require('debug.php');

