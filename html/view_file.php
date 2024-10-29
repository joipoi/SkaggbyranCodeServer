<?php
echo "<a href='/projects.php'>View All Projects</a> <br>";
echo "<a href='/index.php'>Upload A Project</a> <br>";

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
