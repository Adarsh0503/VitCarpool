<?php
session_start();
require_once "db_config.php";

// Check for the form submission to search for trips
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])) {
    // Retrieve form data
    $origin = $_GET["origin"];
    $destination = $_GET["destination"];
    $date = $_GET["date"];
    $time = $_GET["time"];

   
    $sql_select = "SELECT * FROM trip WHERE origin = ? AND destination = ? AND date = ? AND time = ?";
    if ($stmt_select = $mysqli->prepare($sql_select)) {
        $stmt_select->bind_param("ssss", $origin, $destination, $date, $time);
        if ($stmt_select->execute()) {
            $result = $stmt_select->get_result();
            if ($result->num_rows > 0) {
                // Display the matching trips
                while ($row = $result->fetch_assoc()) {
                    echo "<p>Origin: " . $row['origin'] . "</p>";
                    echo "<p>Destination: " . $row['destination'] . "</p>";
                    echo "<p>Date: " . $row['date'] . "</p>";
                    echo "<p>Time: " . $row['time'] . "</p>";
                    // Display more trip details as needed
                    echo "<hr>";
                }
            } else {
                echo "No matching trips found.";
            }
        } else {
            // Error executing SQL statement
            echo "Error executing SQL statement: " . $stmt_select->error;
        }
        $stmt_select->close();
    } else {
        // Error preparing SQL statement
        echo "Error preparing SQL statement: " . $mysqli->error;
    }
}

// Check if the form was submitted to post a new trip
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Retrieve form data
    $origin = $_POST["origin"];
    $destination = $_POST["destination"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $available_seats = $_POST["seats"];

    // Get the current user's ID from session
    $user_id = $_SESSION["id"];

    // Prepare and execute SQL statement to insert data into trip table
    $sql_insert = "INSERT INTO trip (user_id, origin, destination, date, time, available_seats) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt_insert = $mysqli->prepare($sql_insert)) {
        $stmt_insert->bind_param("issssi", $user_id, $origin, $destination, $date, $time, $available_seats);
        if ($stmt_insert->execute()) {
            // Trip data inserted successfully
            echo "Trip data inserted successfully.";
        } else {
            // Error inserting trip data
            echo "Error inserting trip data: " . $stmt_insert->error;
        }
        $stmt_insert->close();
    } else {
        // Error preparing SQL statement
        echo "Error preparing SQL statement: " . $mysqli->error;
    }
}

$mysqli->close();
?>
