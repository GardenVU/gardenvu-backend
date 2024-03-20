<?php
// Include the database configuration file
include 'db_config.php';

// Initialize the $conn variable
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Add CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Prepare SQL statement to get data
    $sql = "SELECT * FROM plot_information";
    $stmt = $conn->prepare($sql);

    // Execute the statement 
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Fetch data
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Convert the data to JSON
        $jsonData = json_encode($data);

        // Output the JSON data
        header('Content-Type: application/json');
        echo $jsonData;
    } else {
        echo "No data found.";
    }

    // Close the result
    $result->close();

    // Close the database connection
    $conn->close();

} else {
    echo "No GET parameters received.";
}