<?php
// Include database connection
include('PUBLICATIONLOGIN/db_connect.php'); // Ensure the correct path to your DB connection file

// Function to generate video previews for YouTube and Google Drive links
function getVideoPreview($description) {
    $videoEmbed = '';

    // Detect YouTube links
    if (preg_match('/(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $description, $matches)) {
        $videoId = $matches[1];
        $videoEmbed = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . htmlspecialchars($videoId) . '" 
                         frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    }

    // Detect Google Drive links
    if (preg_match('/(?:https?:\/\/)?(?:drive\.google\.com\/file\/d\/)([a-zA-Z0-9_-]+)/', $description, $matches)) {
        $fileId = $matches[1];
        $videoEmbed = '<iframe src="https://drive.google.com/file/d/' . htmlspecialchars($fileId) . '/preview" 
                         width="560" height="315" frameborder="0" allow="autoplay"></iframe>';
    }

    return $videoEmbed;
}

// Fetch the documents from the database
$query = "SELECT * FROM documents ORDER BY date_created DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any documents to display
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $title = $row['title'];
        $description = $row['description'];
        $file_json = $row['file_json'];
        $date_created = $row['date_created'];
        $user_id = $row['user_id'];

        // Fetch the username securely
        $userQuery = "SELECT firstname FROM users WHERE id = ?";
        $userStmt = $conn->prepare($userQuery);
        $userStmt->bind_param("i", $user_id);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        $user = $userResult->fetch_assoc();
        $username = $user['firstname'] ?? 'Unknown';

        // Decode JSON file data (if files are attached)
        $files = json_decode($file_json, true);
?>

<div class="post">
    <div class="post-header">
        <span class="username"><?php echo htmlspecialchars($username); ?></span> • 
        <span class="post-time"><?php echo date('F j, Y, g:i a', strtotime($date_created)); ?></span>
    </div>
    <div class="post-body">
        <h4 class="post-title"><?php echo htmlspecialchars($title); ?></h4>
        <p class="post-description"><?php echo nl2br(htmlspecialchars_decode($description)); ?></p>

        <!-- Generate and display video preview if link is detected -->
        <?php 
        $videoPreview = getVideoPreview($description);
        if ($videoPreview) {
            echo '<div class="video-preview">' . $videoPreview . '</div>';
        }
        ?>
    </div>

    <!-- Display uploaded files if available -->
    <?php if (!empty($files)) { ?>
    <div class="post-files">
        <?php foreach ($files as $file) { 
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $filePath = 'PUBLICATIONLOGIN/assets/uploads/' . htmlspecialchars($file);

            // Check the file type and display appropriately
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'jfif'])) {
                // Display image files as thumbnails
                echo '<img src="' . $filePath . '" alt="' . htmlspecialchars($file) . '" class="file-thumbnail" />';
            } elseif (in_array($ext, ['mp4', 'webm', 'ogg'])) {
                // Display video files
                echo '<video controls class="file-video">
                        <source src="' . $filePath . '" type="video/' . $ext . '">
                        Your browser does not support the video tag.
                      </video>';
            } else {
                // Display other file types as text links
                echo '<a href="' . $filePath . '" target="_blank">' . htmlspecialchars($file) . '</a>';
            }
        } ?>
    </div>
    <?php } ?>
</div>

<?php 
    }
} else {
    echo "<p>No posts available.</p>";
}
?>
