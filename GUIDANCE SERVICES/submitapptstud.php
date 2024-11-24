<?php
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['studentName'];
    $section = $_POST['section'];
    $counselor = $_POST['counselor'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO aptstuddb (NAME, SECTION, COUNSELOR, DATE, TIME, MESSAGE) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $section, $counselor, $date, $time, $message);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Appointment successfully submitted!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to submit the appointment."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
