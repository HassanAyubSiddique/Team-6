<?php
session_start();
// Database configuration
$dbHost     = "localhost";
$dbUsername = "root";
$dbPassword = "root";
$dbName     = "rakusen";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>