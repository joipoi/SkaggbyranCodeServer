<?php

session_start();

// Get user and project information
$user = isset($_GET['user']) ? $_GET['user'] : 'guest';
$project = isset($_GET['project']) ? $_GET['project'] : 'defaultProject';
$file = isset($_GET['file']) ? $_GET['file'] : '';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']);
$currentUser = $isLoggedIn ? $_SESSION['username'] : 'guest';

// Define the project directory
$projectDir = "uploads/$user/$project/$file";

// Security check: Allow deletion only if the user is the project owner or if it's a guest project
if ($isLoggedIn && $currentUser !== $user) {
    echo "You do not have permission to delete this file.";
    exit;
}

// Allow deletion if it's a guest project or if the user is the owner
if (file_exists($projectDir)) {
    unlink($projectDir);
    echo "File deleted successfully. <a href='view_file.php?user=" . urlencode($user) . "&project=" . urlencode($project) . "'>Go back</a>";
} else {
    echo "File does not exist.";
}
?>
