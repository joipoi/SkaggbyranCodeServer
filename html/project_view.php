<?php
echo "<a href='/projects.php'>View All Projects</a> <br>";
echo "<a href='/index.php'>Upload A Project</a> <br>";

if (isset($_GET['user']) && isset($_GET['project'])) {
    $username = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['user']);
    $projectName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['project']);
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
} else {
    echo "No user or project specified.";
}
?>
