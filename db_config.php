<?php
// Database configuration
$db_host = "localhost"; // Your database host
$db_username = "root"; // Your database username
$db_password = ''; // Your database password
$db_name = "carpool"; // Your database name

// Create connection
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($mysqli->connect_error) {
    // Connection failed
    die("Connection failed: " . $mysqli->connect_error);
} else {
    // Connection successful
    echo "Connected successfully<br>";

    // Test Query: Select data from a sample table
    $test_query = "SELECT * FROM users LIMIT 5"; // Replace 'users' with an actual table name
    $result = $mysqli->query($test_query);

    if ($result) {
        // Query executed successfully
        if ($result->num_rows > 0) {
            // Data retrieved from the table
            echo "<br>Sample data from the users table:<br>";
            while ($row = $result->fetch_assoc()) {
                // Display each row of data
                echo "ID: " . $row["id"] . " - Name: " . $row["username"] . "<br>"; // Assuming 'username' is a column in your 'users' table
            }
        } else {
            echo "<br>No data found in the users table.<br>";
        }
    } else {
        // Query execution failed
        echo "<br>Error executing the test query: " . $mysqli->error . "<br>";
    }

    // Test Insert: Insert data into the users table
    $test_insert_query = "INSERT INTO users (username, email, password) VALUES ('test_user', 'test@example.com', 'testpassword')"; // Replace 'users' with an actual table name
    if ($mysqli->query($test_insert_query) === TRUE) {
        // Data inserted successfully
        echo "<br>New record inserted successfully.<br>";
    } else {
        // Insertion failed
        echo "<br>Error inserting data: " . $mysqli->error . "<br>";
    }

    // Close connection
    $mysqli->close();
}
?>
