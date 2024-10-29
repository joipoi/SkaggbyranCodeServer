<?php
session_start();

$user = isset($_GET['user']) ? $_GET['user'] : 'guest';
$project = isset($_GET['project']) ? $_GET['project'] : 'defaultProject';
$file = isset($_GET['file']) ? $_GET['file'] : '';

$projectDir = "uploads/$user/$project/$file";

// Check if the file exists
if (file_exists($projectDir)) {
    unlink($projectDir); // Delete the file
    echo "File deleted successfully. <a href='view_file.php?user=" . urlencode($user) . "&project=" . urlencode($project) . "'>Go back</a>";
} else {
    echo "File does not exist.";
}
?>
