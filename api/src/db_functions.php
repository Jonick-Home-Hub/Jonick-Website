<?php
// Database connection using PDO
function db_connect()
{
    $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4";

    try {
        $database = new PDO($dsn, DB_USER, DB_PASS);
        // Set PDO attributes for error handling and default fetch mode
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $database;
    } catch (PDOException $e) {
        // Handle connection errors
        exit("Database Connection Failed: " . $e->getMessage());
    }
}

// Function to disconnect the database (optional with PDO)
function db_disconnect(&$database)
{
    if (isset($database)) {
        $database = null; // Setting to null closes the connection in PDO
    }
}
