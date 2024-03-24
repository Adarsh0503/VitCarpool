<?php
// Database configuration
$db_host = "localhost"; // Your database host
$db_username = "root"; // Your database username
$db_password = ""; // Your database password
$db_name = "carpool"; // Your database name

// Create connection
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($mysqli->connect_error) {
    // Connection failed
    die("Connection failed: " . $mysqli->connect_error);
} else {
    // Connection successful
    echo "Connected successfully";
}

// Close connection (optional)
$mysqli->close();
?>
