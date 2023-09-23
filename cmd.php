<?php

if (php_sapi_name() !== 'cli') {
    // Exit the script if it is not being run from the terminal.
    exit('This script can only be run from the terminal.');
}


// Read user input from the command line
if (isset($argv[1])) {
    $userInput = trim($argv[1]);
} else {
    die("Usage: php cmd.php <CONSTANT_NAME>:<NEW_VALUE>\n");
}

// Parse the input
list($constantName, $newValue) = explode(':', $userInput);

// Include the config.php file
include('config.example.php');

// Check if the constant is already defined with the desired value
if (defined($constantName) && constant($constantName) === $newValue) {
    echo "$constantName is already set to $newValue in config.php\n";
} else {
    // Read the content of config.php
    $configContent = file_get_contents('config.example.php');

    // Use a more precise regex to update the constant definition with double quotes
    $pattern = '/define\("' . $constantName . '",\s*"[^"]*"\);/';
    $replacement = 'define("' . $constantName . '", "' . $newValue . '");';
    $updatedConfigContent = preg_replace($pattern, $replacement, $configContent);

    // Write the updated config back to config.php
    if (file_put_contents('config.php', $updatedConfigContent) !== false) {
        echo "Updated $constantName to $newValue in config.php\n";
    } else {
        echo "Failed to update $constantName in config.php\n";
    }
}