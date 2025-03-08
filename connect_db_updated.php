<?php
// connection.php
$host = "localhost";
$user = "simo";
$password = "simo";
$database = "datamjpjaouda"; // Replace with your actual DB name

// Create connection
$mysqli = new mysqli($host, $user, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>