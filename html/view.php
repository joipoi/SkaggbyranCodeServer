<?php
// view.php
echo "<a href='/projects.php'>View All Projects</a> <br>";
echo "<a href='/index.php'>Upload Project</a>";
if (isset($_GET['user']) && isset($_GET['project'])) {
    $username = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['user']); //gets rid of anything that is not a letter, number, dash or underscore
    $projectName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['project']); //gets rid of anything that is not a letter, number, dash or underscore
    $directory = "uploads/$username/$projectName/";

    if (is_dir($directory)) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        echo "<h1>Uploaded Files for $username - Project: $projectName</h1>";
        echo "<ul>";
        foreach ($files as $file) {
            if ($file->isFile()) {
                $filePath = $file->getPathname();
                $relativePath = str_replace($directory, '', $filePath);
                
                // Generate links for HTML files
                if (pathinfo($filePath, PATHINFO_EXTENSION) === "html") {
                    echo "<li><a href='uploads/$username/$projectName/" . htmlspecialchars($relativePath) . "' target='_blank'>" . htmlspecialchars($relativePath) . "</a></li>";
                }
            }
        }
        echo "</ul>";
    } else {
        echo "No files found for user $username in project $projectName.";
    }
} else {
    echo "No user or project specified.";
}
?>
