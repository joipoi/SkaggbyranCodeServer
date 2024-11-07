<?php

session_start();

// Get user and project information
$projectUser = isset($_GET['user']) ? $_GET['user'] : 'guest';
$project = isset($_GET['project']) ? $_GET['project'] : 'defaultProject';
$file = isset($_GET['file']) ? $_GET['file'] : '';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']);
$currentUser = $isLoggedIn ? $_SESSION['username'] : 'guest';

// Define the project directory
$projectDir = "uploads/$projectUser/$project/$file";

// Security check: Allow deletion only if the user is the project owner or if it's a guest project
if ($currentUser !== $projectUser && $projectUser !== 'guest') {
	echo "You do not have permission to delete this file.";
    exit;
}
// Allow deletion if it's a guest project or if the user is the owner
if (file_exists($projectDir)) {
    unlink($projectDir);
   // echo "File deleted successfully. <a href='file_list.php?user=" . urlencode($user) . "&project=" . urlencode($project) . "'>Go back</a>";
    header("Location: file_list.php?user=" . urlencode($projectUser) . "&project=" . urlencode($project)); 
    exit();
} else {
    echo "File does not exist.";
}
?>
