<?php
session_start();

$user = isset($_GET['user']) ? $_GET['user'] : 'guest';
$project = isset($_GET['project']) ? $_GET['project'] : 'defaultProject';

$projectDir = "uploads/$user/$project";

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

    echo "Project deleted successfully. <a href='projects.php'>Go back to Projects</a>";
} else {
    echo "Project does not exist.";
}
?>
