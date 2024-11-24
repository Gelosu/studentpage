<?php
// Include the database connection
include('connect.php');

// Fetch all records from the database
$query = "SELECT ID, NAME, SECTION, SPORT, PSA_PATH, GRADEPATH, IDPATH, UPLOADDT FROM sportdb ORDER BY UPLOADDT DESC";
$result = $conn->query($query);

// Check if there are records
if ($result->num_rows > 0) {
    $files = [];
    while ($row = $result->fetch_assoc()) {
        $files[] = $row; // Add each row to the files array
    }
    // Return JSON response
    echo json_encode(["success" => true, "data" => $files]);
} else {
    echo json_encode(["success" => false, "message" => "No files found."]);
}

// Close the connection
$conn->close();
?>
