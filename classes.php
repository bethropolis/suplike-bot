<?php

function customAutoloader($className)
{
    // Define the base directory for your classes
    $baseDir = __DIR__ . '/methods/';

    // Replace backslashes with forward slashes (for cross-platform compatibility)
    $className = str_replace('\\', '/', $className);

    // Construct the full path to the class file
    $classFile = $baseDir . $className . '.php';

    // Check if the class file exists
    if (file_exists($classFile)) {
        // Include the class file
        require_once($classFile);
    }
}

// Register the custom autoloader function
spl_autoload_register('customAutoloader');

require('bot.php');
require('debug.php');

