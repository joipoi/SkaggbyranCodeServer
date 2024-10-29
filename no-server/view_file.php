<?php
session_start();

// Display navigation links
echo '<p> <a href="index.php">Upload A Project</a> | <a href="projects.php">View All Projects</a> | <a href="login.php">Login</a> | <a href="register.php">Register</a>  </p>';

$user = isset($_GET['user']) ? urlencode($_GET['user']) : 'guest';
$project = isset($_GET['project']) ? urlencode($_GET['project']) : 'defaultProject';
$file = isset($_GET['file']) ? $_GET['file'] : '';

// Create the link to file_list.php
$file_list_link = "file_list.php?user=$user&project=$project";
echo "<a href='$file_list_link'>Back</a>";

if ($file) {
    $username = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['user']);
    $projectName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['project']);
    $fileName = preg_replace('/[^a-zA-Z0-9_.-]/', '', $file);
    $filePath = "uploads/$username/$projectName/$fileName";

    if (file_exists($filePath)) {
        $fileContent = file_get_contents($filePath);
        echo "<h1>Viewing File: $fileName</h1>";
        echo "<pre>" . htmlspecialchars($fileContent) . "</pre>";

        // Check if user is the owner or a guest to show edit/delete options
	if ($user === 'guest' || (isset($_SESSION['username']) && $user === $_SESSION['username'])) {
	echo "<p><a href='edit_file.php?user=" . urlencode($user) . "&project=" . urlencode($project) . "&file=" . urlencode($fileName) . "'>Edit</a> | ";
            echo "<a href='delete_file.php?user=" . urlencode($user) . "&project=" . urlencode($project) . "&file=" . urlencode($fileName) . "' onclick='return confirm(\"Are you sure you want to delete this file?\");'>Delete</a></p>";
        }
    } else {
        echo "File not found.";
    }
} else {
    echo "No user, project, or file specified.";
}
?>
