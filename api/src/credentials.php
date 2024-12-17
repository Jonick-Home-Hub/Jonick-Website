<?php

// Load the .env file and parse it
if (file_exists(filename: __DIR__ . '/key.env')) {
    $env = parse_ini_file(__DIR__ . '/key.env');
} else {
    exit('.env file not found');
}

// Define constants from the .env file
define("DB_SERVER", $env['DB_SERVER'] ?? 'localhost');
define("DB_USER", $env['DB_USER'] ?? 'root');
define("DB_PASS", $env['DB_PASS'] ?? '');
define("DB_NAME", $env['DB_NAME'] ?? 'jonick_home_hub');
