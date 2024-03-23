<?php
// Include the database configuration file
include 'db-connect.php';

// Initialize the $conn variable
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Add CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Check if GET parameters exist
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get the GET parameters
    $plot_id = (int)$_GET['plot_id'];

    // Adjusted format for the date string
    $format = 'Y-m-d\TH:i:s.v\Z';

    $startDate = DateTime::createFromFormat($format, $_GET['start_date']);
    $endDate = DateTime::createFromFormat($format, $_GET['end_date']);

    // Check if the parameters are valid and dates are properly parsed
    if ($plot_id && $startDate && $endDate) {
        
        // Set the time zone to the local time zone
        date_default_timezone_set('America/Chicago');

        // Set the time zone for the start and end dates
        $startDate->setTimezone(new DateTimeZone('America/Chicago'));
        $endDate->setTimezone(new DateTimeZone('America/Chicago'));

        // Format dates to string for SQL query
        $formattedStartDate = $startDate->format('Y-m-d H:i:s');
        $formattedEndDate = $endDate->format('Y-m-d H:i:s');

        // Prepare SQL statement to get data
        $sql = "SELECT * FROM sensor_data WHERE plot_id = ? AND time_collected BETWEEN ? AND ? ORDER BY time_collected ASC";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the parameters
            $stmt->bind_param("iss", $plot_id, $formattedStartDate, $formattedEndDate);

            // Execute the statement
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Fetch data
                $sensorData = [];
                while ($row = $result->fetch_assoc()) {
                    $row['id'] = (int)$row['id'];
                    $row['plot_id'] = (int)$row['plot_id'];
                    $row['temperature'] = (float)$row['temperature'];
                    $row['pH'] = (float)$row['pH'];
                    $row['tds'] = (float)$row['tds'];
                    $row['time_collected'] = $row['time_collected'];
                    $sensorData[] = $row;
                }

                // Convert the data to JSON
                $jsonData = json_encode($sensorData);

                // Output the JSON data
                header('Content-Type: application/json');
                echo $jsonData;
            } else {
                // Return empty json array if no data found
                $jsonData = json_encode([]);

                // Output the JSON data
                header('Content-Type: application/json');
                echo $jsonData;
            }

            // Close the result
            $result->close();
        } else {
            echo "Invalid GET parameters.";
        }

    // Close the database connection
    $conn->close();
    
    } else {
        echo "Invalid GET parameters.";
    }

} else {
    echo "No GET parameters received.";
}
?>