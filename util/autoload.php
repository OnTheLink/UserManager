<?php
// Autoload util classes (controllers, models, etc.) all of which are within subdirectories of util
$forbiddenAutoload = [
    'routes'
];

foreach (glob(__DIR__ . '/**/**/*.php') as $filename) {
    $skipFile = false;

    foreach ($forbiddenAutoload as $forbiddenItem) {
        if (str_contains($filename, $forbiddenItem)) {
            $skipFile = true;
            break; // No need to continue checking once we find a match
        }
    }

    if ($skipFile) {
        continue; // Skip this file
    }

    require_once $filename;
}

foreach (glob(__DIR__ . '/**/*.php') as $filename) {
    $skipFile = false;

    foreach ($forbiddenAutoload as $forbiddenItem) {
        if (str_contains($filename, $forbiddenItem)) {
            $skipFile = true;
            break; // No need to continue checking once we find a match
        }
    }

    if ($skipFile) {
        continue; // Skip this file
    }

    require_once $filename;
}

// Load routes
require_once(__DIR__ . '/routing/routes.php');

// Load error messages
require_once(__DIR__ . '/../lang/ErrorMessages.php');

// Load global styles
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">';
echo '<link rel="stylesheet" href="' . resourceURL . '/css/global.css">';
