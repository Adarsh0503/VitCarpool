<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit; // Exit script to prevent further execution
}

// Include database configuration
require_once "db_config.php";

// Fetch user details from the database
$user_id = $_SESSION["id"];
$sql = "SELECT fullname, email /* Add more fields if needed */ FROM users WHERE id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($fullname, $email /* Add more fields if needed */);
            $stmt->fetch();
        } else {
            echo "Error: User not found.";
            exit;
        }
    } else {
        echo "Error fetching user details.";
        exit;
    }
    $stmt->close();
} else {
    echo "Error preparing SQL statement.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css"> <!-- Add your profile page styles -->
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <div class="profile-info">
            <p><strong>Name:</strong> <?php echo $fullname; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <!-- Add more profile fields here -->
        </div>
        <a href="edit_profile.php">Edit Profile</a>
        <a href="welcome.html">Back</a> <!-- Link to edit profile page -->
    </div>
</body>
</html>
