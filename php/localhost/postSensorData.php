<?php
// Include the database configuration file
include 'db_config.php';

// Initialize the $conn variable
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check if POST data exists
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the post data
    $temperature = isset($_POST['temperature']) ? $_POST['temperature'] : null;
    $pH = isset($_POST['pH']) ? $_POST['pH'] : null;
    $tds = isset($_POST['tds']) ? $_POST['tds'] : null;
    $timestamp = date('Y-m-d H:i:s');

    // Prepare SQL statement to insert data
    $sql = "INSERT INTO sensor_data (temperature, pH, tds, timestamp) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dddds", $temperature, $pH, $tds, $timestamp);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Data inserted successfully.";
    } else {
        echo "Data failed to insert.";
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
} else {
    echo "No POST data received.";
}
?>
