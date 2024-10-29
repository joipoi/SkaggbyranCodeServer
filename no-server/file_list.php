<?php
// file_list.php
echo ' <p> <a href="index.php">Upload A Project</a> | <a href="projects.php">View All Projects</a> | <a href="login.php">Login</a> | <a href="register.php">Register</a>  </p>';
if (isset($_GET['user']) && isset($_GET['project'])) {
    $username = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['user']);
    $projectName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['project']);
    $directory = "uploads/$username/$projectName/";

    if (is_dir($directory)) {
        echo "<h1>Files in Project: $projectName</h1>";
        $files = glob($directory . '*');

        if (empty($files)) {
            echo "<p>No files found in this project.</p>";
        } else {
            echo "<ul>";
            foreach ($files as $file) {
                if (is_file($file)) {
                    $fileName = basename($file);
                    echo "<li><a href='$file' target='_blank'>" . htmlspecialchars($fileName) . "</a> - <a href='view_file.php?user=" . urlencode($username) . "&project=" . urlencode($projectName) . "&file=" . urlencode($fileName) . "'>View Contents</a></li>";
                }
            }
            echo "</ul>";
        }
    } else {
        echo "No files found for user $username in project $projectName.";
    }
} else {
    echo "No user or project specified.";
}
?>
