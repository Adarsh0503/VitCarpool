<?php
session_start();
require_once "db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required form fields are set
    if(isset($_POST["origin"], $_POST["destination"], $_POST["date"], $_POST["time"], $_POST["seats"])) {
        $user_id = $_SESSION["id"];
        $origin = $_POST["origin"];
        $destination = $_POST["destination"];
        $date = $_POST["date"];
        $time = $_POST["time"];
        $seats = $_POST["seats"];

        // Prepare SQL statement
        $sql = "INSERT INTO trip (user_id, origin, destination, date, time, available_seats) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind parameters and execute SQL statement
            $stmt->bind_param("issssi", $user_id, $origin, $destination, $date, $time, $seats);
            if ($stmt->execute()) {
                // Trip posted successfully
                echo "<script>alert('Trip posted successfully.'); window.location.href = 'welcome.html';</script>";
                exit; // Stop further execution
            } else {
                echo "Error: " . $stmt->error;
            }
            // Close statement
            $stmt->close();
        } else {
            echo "Error preparing SQL statement: " . $mysqli->error;
        }
    } else {
        echo "All form fields are required.";
    }

    // Close database connection
    $mysqli->close();
}
?>
