<?php
// Include the database configuration file
include 'db_config.php';

// Initialize the $conn variable
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Add CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Check if GET parameters exist
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get the GET parameters, or 10 for default
    $num_points = isset($_GET['num_points']) ? (int)$_GET['num_points'] : 10; 

    // Prepare SQL statement to get distinct plot_ids
    $plotIdsSql = "SELECT id FROM plot_information";
    $plotIdsResult = $conn->query($plotIdsSql);

    if ($plotIdsResult) {
        $data = [];
        while ($plotRow = $plotIdsResult->fetch_assoc()) {
            $plot_id = (int)$plotRow['id'];

            // Prepare SQL statement to get data for each plot_id
            $sensorDataSql = "SELECT * FROM (
                                SELECT * FROM sensor_data 
                                WHERE plot_id = ? 
                                ORDER BY time_collected DESC 
                                LIMIT ?
                              ) AS sub ORDER BY time_collected ASC";
            
            $stmt = $conn->prepare($sensorDataSql);
            if ($stmt) {
                // Bind the parameters
                $stmt->bind_param("ii", $plot_id, $num_points);

                // Execute the statement
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $sensorData = [];
                    while ($row = $result->fetch_assoc()) {
                        $row['id'] = (int)$row['id'];
                        $row['plot_id'] = (int)$row['plot_id'];
                        $row['temperature'] = (float)$row['temperature'];
                        $row['pH'] = (float)$row['pH'];
                        $row['tds'] = (float)$row['tds'];
                        $row['waterLevel'] = (float)$row['waterLevel'];
                        $row['time_collected'] = $row['time_collected'];
                        $sensorData[] = $row;
                    }
                    $data[] = [
                        'plot_id' => $plot_id,
                        'data' => $sensorData
                    ];
                }
            }
        }

        // Convert the data to JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo "Failed to get plot IDs.";
    }

    // Close the database connection
    $conn->close();

} else {
    echo "No GET parameters received.";
}
?>
