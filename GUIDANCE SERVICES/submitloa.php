<?php
include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['studentName'];
    $section = $_POST['section'];
    $date = $_POST['date'];
    $interviewDate = $_POST['interviewDate'];
    $leaveStart = $_POST['leaveStart'];
    $reason = $_POST['reason'];

    $stmt = $conn->prepare("INSERT INTO studloa_db (NAME, CSYRSC, DATE, INTERVIEW, LSTART, REASON) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $section, $date, $interviewDate, $leaveStart, $reason);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Leave of Absence successfully submitted!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to submit the Leave of Absence."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>
