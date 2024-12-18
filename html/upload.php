<?php
session_start();

// MySQL connection logic here
$servername = getenv('DB_SERVER');
$db_username = getenv('DB_USER');
$db_password = getenv('DB_PASS');
$dbname = getenv('DB_NAME');

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the username and sanitize it
    $username = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['username']);
    $projectname = preg_replace('/[^a-zA-Z0-9_-]/', '', $_POST['projectname']);
    
    $baseDir = "uploads/$username/";

    // Check if the user directory exists; if not, create it
    if (!is_dir($baseDir)) {
        mkdir($baseDir, 0755, true);
    }

    // Create a project folder based on the uploaded folder name
    $projectDir = $baseDir . $projectname . '/';

    // Check if the project directory exists; if not, create it
    if (!is_dir($projectDir)) {
        mkdir($projectDir, 0755, true);
    }

    // Define allowed file types
    $allowedFileTypes = [
        'html' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp'
    ];

    foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
        $filePath = $_FILES['files']['name'][$key];
        $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
        
        // Check if the file extension is allowed
        if (!array_key_exists($fileExt, $allowedFileTypes)) {
            echo "Invalid file type for file: " . htmlspecialchars($filePath) . ".<br>";
            continue; // Skip this file
        }

        $targetFile = $projectDir . $filePath;

        // Create directories if necessary
        $directory = dirname($targetFile);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Move the uploaded file to the target project directory
        if (move_uploaded_file($tmpName, $targetFile)) {
            echo "The file " . htmlspecialchars($filePath) . " has been uploaded.<br>";
        } else {
            echo "Error uploading " . htmlspecialchars($filePath) . ".<br>";
        }
    }
   // echo "<br><a href='project_view.php?user=$username&project=$projectname'>View Uploaded Files</a>";
   header("Location: project_view.php?user=$username&project=$projectname"); // Redirect to upload page
   exit();

} else {
    echo "Invalid request.";
}
?>