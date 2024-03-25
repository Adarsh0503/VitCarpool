<?php
// Start the session
session_start();

// Include the database configuration file
require_once "db_config.php";



// Check if the required parameters are set
if(isset($_GET["origin"], $_GET["destination"], $_GET["date"])) {
    // Get the search criteria
    $origin = $_GET["origin"];
    $destination = $_GET["destination"];
    $date = $_GET["date"];

    // Prepare and execute SQL statement to search for trips based on the criteria
    $sql = "SELECT u.fullname, u.email FROM users u INNER JOIN trip t ON u.id = t.user_id WHERE t.origin = ? AND t.destination = ? AND t.date = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sss", $origin, $destination, $date);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Display user details as a table inside the searchResults div
                echo '<div id="searchResults">';
                echo '<table >';
                echo '<thead><tr><th>Full Name</th><th>Email</th></tr></thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>{$row['fullname']}</td><td>{$row['email']}</td></tr>";
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                echo "No users found.";
            }
        } else {
            echo "Error executing SQL statement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $mysqli->error;
    }
}

// Close the database connection
$mysqli->close();
?>
