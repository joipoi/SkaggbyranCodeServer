<?php
echo ' <p> <a href="index.php">Upload A Project</a> | <a href="projects.php">View All Projects</a> | <a href="login.php">Login</a> | <a href="register.php">Register</a>  </p>';
$user = isset($_GET['user']) ? urlencode($_GET['user']) : 'guest';
$project = isset($_GET['project']) ? urlencode($_GET['project']) : 'defaultProject';

// Create the link to file_list.php
$file_list_link = "file_list.php?user=$user&project=$project";

// Output the HTML link
echo "<a href='$file_list_link'>Back</a>";

if (isset($_GET['user']) && isset($_GET['project']) && isset($_GET['file'])) {
    $username = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['user']);
    $projectName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['project']);
    $fileName = preg_replace('/[^a-zA-Z0-9_.-]/', '', $_GET['file']);
    $filePath = "uploads/$username/$projectName/$fileName";

    if (file_exists($filePath)) {
        $fileContent = file_get_contents($filePath);
        echo "<h1>Viewing File: $fileName</h1>";
        echo "<pre>" . htmlspecialchars($fileContent) . "</pre>";
    } else {
        echo "File not found.";
    }
} else {
    echo "No user, project, or file specified.";
}
?>
