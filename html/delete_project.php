<?php
session_start();

// Get user and project information
$user = isset($_GET['user']) ? $_GET['user'] : 'guest';
$project = isset($_GET['project']) ? $_GET['project'] : 'defaultProject';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']);
$currentUser = $isLoggedIn ? $_SESSION['username'] : 'guest';

// Define the project directory
$projectDir = "uploads/$user/$project";

// Security check: Allow deletion only if the user is the project owner or if it's a guest project
if ($currentUser !== $user && $user !== 'guest') {
        echo "You do not have permission to delete this file.";
    exit;
}

// Check if the project directory exists
if (is_dir($projectDir)) {
    // Recursively delete the project directory and its contents
    $files = array_diff(scandir($projectDir), array('.', '..'));
    foreach ($files as $file) {
        $filePath = "$projectDir/$file";
        if (is_dir($filePath)) {
            // Recursively delete directory
            array_map('unlink', glob("$filePath/*.*")); // delete files
            rmdir($filePath); // delete directory
        } else {
            unlink($filePath); // delete file
        }
    }
    rmdir($projectDir); // delete the project directory

    //echo "Project deleted successfully. <a href='projects.php'>Go back to Projects</a>";
    header("Location: projects.php"); 
    exit();
} else {
    echo "Project does not exist.";
}
?>
