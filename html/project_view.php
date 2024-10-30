<?php
echo ' <p> <a href="index.php">Upload A Project</a> | <a href="projects.php">View All Projects</a> | <a href="login.php">Login</a> | <a href="register.php">Register</a>  </p>';
if (isset($_GET['user']) && isset($_GET['project'])) {

$username = isset($_GET['user']) ? urlencode($_GET['user']) : 'guest';
$projectName = isset($_GET['project']) ? urlencode($_GET['project']) : 'defaultProject';


    $directory = "uploads/$username/$projectName/";

    if (is_dir($directory)) {
        echo "<h1>Project: $projectName</h1>";
        
        // Find the starting file (index.html or similar)
        $htmlFiles = glob($directory . '*.html');
        $startFile = null;

        foreach ($htmlFiles as $file) {
            $filename = basename($file);
            if (strtolower($filename) === 'index.html' || strpos(strtolower($filename), 'home') !== false) {
                $startFile = $file; // Prioritize index.html or home.html
                break;
            }
        }

        // If no special file is found, pick a random HTML file
        if ($startFile === null && !empty($htmlFiles)) {
            $startFile = $htmlFiles[array_rand($htmlFiles)];
        }

        // Display links
        echo "<p><a href='" . htmlspecialchars($startFile) . "' target='_blank'>View Project</a></p>";
        
        // Option to view the list of files
        echo "<p><a href='file_list.php?user=" . urlencode($username) . "&project=" . urlencode($projectName) . "'>View Files in Project</a></p>";
    } else {
        echo "No files found for user $username in project $projectName.";
    }

// Add link to download the project
    echo "<p><a href='download_project.php?user=" . urlencode($username) . "&project=" . urlencode($projectName) . "'>Download Project</a></p>";

// Add link to delete the project
if ($username === 'guest' || (isset($_SESSION['username']) && $_SESSION['username'] === $user)) {
    echo "<p><a href='delete_project.php?user=" . urlencode($username) . "&project=" . urlencode($projectName) . "' onclick='return confirm(\"Are you sure you want to delete this project?\");'>Delete Project</a></p>";
}

} else {
    echo "No user or project specified.";
}
?>
