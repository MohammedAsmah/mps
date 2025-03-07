<?php
// ============================================
// DATABASE CONFIGURATION (Update these values)
// ============================================
$db_host = 'localhost';    // Host (usually 'localhost' for XAMPP)
$db_user = 'simo';         // Default XAMPP username
$db_pass = 'simo';             // Default XAMPP password (empty)
$db_name = 'datamjpjaouda'; // Your database name

// ============================================
// CREATE DATABASE CONNECTION (MySQLi)
// ============================================
try {
    // Create a MySQLi connection
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Check connection errors
    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }

    // Set charset to UTF-8 for proper encoding
    $mysqli->set_charset("utf8mb4");

    // Optional: Confirm connection (for debugging)
    // echo "Connected successfully to database: " . $db_name;

} catch (Exception $e) {
    // Handle errors gracefully (avoid exposing sensitive info in production)
    error_log("Database error: " . $e->getMessage());
    die("Failed to connect to the database. Please try again later.");
}
?>