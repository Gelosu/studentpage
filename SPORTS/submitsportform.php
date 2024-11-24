<?php
// Include database connection
include('../connect.php'); // Ensure proper database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = strtoupper(str_replace(' ', '', $_POST['name'])); // Convert to uppercase and remove spaces
    $section = $_POST['section'];
    $sport = $_POST['sportslist'];
    $timestamp = date("Y-m-d H:i:s"); // Current timestamp

    // Base folder for uploads
    $baseFolder = "UPLOADS"; // Physical location for uploaded files
    $userFolder = "$baseFolder/$name"; // User-specific folder
    $psaFolder = "$userFolder/PSA";
    $gradeFolder = "$userFolder/GRADECOPY";
    $schoolIdFolder = "$userFolder/SCHOOLID";

    // Create directories if they don't exist
    foreach ([$baseFolder, $userFolder, $psaFolder, $gradeFolder, $schoolIdFolder] as $folder) {
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true); // Recursive creation with proper permissions
        }
    }

    // Define uploaded files
    $psaFile = $_FILES['psa'];
    $gradeFile = $_FILES['grade'];
    $schoolIdFile = $_FILES['school-id'];

    // Allowed file types for validation
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

    // Function to validate file type
    function isValidFileType($file, $allowedTypes) {
        return in_array($file['type'], $allowedTypes);
    }

    // Validate file types
    foreach (['psa' => $psaFile, 'grade' => $gradeFile, 'schoolId' => $schoolIdFile] as $key => $file) {
        if (!isValidFileType($file, $allowedTypes)) {
            echo json_encode([
                "success" => false,
                "message" => "Invalid file type for " . ucfirst($key) . ". Only images and PDFs are allowed."
            ]);
            exit;
        }
    }

    // Sanitize file names
    $psaFileName = basename($psaFile['name']);
    $gradeFileName = basename($gradeFile['name']);
    $schoolIdFileName = basename($schoolIdFile['name']);

    // Define final file paths for physical storage
    $psaFinalPath = "$psaFolder/$psaFileName";
    $gradeFinalPath = "$gradeFolder/$gradeFileName";
    $schoolIdFinalPath = "$schoolIdFolder/$schoolIdFileName";

    // Move uploaded files to their respective folders
    move_uploaded_file($psaFile['tmp_name'], $psaFinalPath);
    move_uploaded_file($gradeFile['tmp_name'], $gradeFinalPath);
    move_uploaded_file($schoolIdFile['tmp_name'], $schoolIdFinalPath);

    // Prepare database paths (SPORTS as the prefix for database storage)
    $psaDbPath = "SPORTS/UPLOADS/$name/PSA/$psaFileName";
    $gradeDbPath = "SPORTS/UPLOADS/$name/GRADECOPY/$gradeFileName";
    $schoolIdDbPath = "SPORTS/UPLOADS/$name/SCHOOLID/$schoolIdFileName";

    // Escape data for database insertion
    $nameEscaped = mysqli_real_escape_string($conn, $name);
    $sectionEscaped = mysqli_real_escape_string($conn, $section);
    $sportEscaped = mysqli_real_escape_string($conn, $sport);
    $psaEscaped = mysqli_real_escape_string($conn, $psaDbPath);
    $gradeEscaped = mysqli_real_escape_string($conn, $gradeDbPath);
    $schoolIdEscaped = mysqli_real_escape_string($conn, $schoolIdDbPath);

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO sportdb (NAME, SECTION, SPORT, PSA_PATH, GRADEPATH, IDPATH, UPLOADDT) 
    VALUES (?, ?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param("ssssss", $nameEscaped, $sectionEscaped, $sportEscaped, $psaEscaped, $gradeEscaped, $schoolIdEscaped);

    // Execute the query and return a response
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Submit Successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to submit the form."]);
    }

    // Close the prepared statement
    $stmt->close();
}
?>
