<?php
session_start();

// Sanitize input
$projectUser = isset($_GET['user']) ? urlencode($_GET['user']) : 'guest';
$project = isset($_GET['project']) ? urlencode($_GET['project']) : 'defaultProject';
$file = isset($_GET['file']) ? $_GET['file'] : '';
$filePath = "uploads/$projectUser/$project/$file";
$isLoggedIn = isset($_SESSION['username']);
$currentUser = $isLoggedIn ? $_SESSION['username'] : 'guest';

// Create the link to file_list.php
$file_list_link = "project_view.php?user=$projectUser&project=$project";

function displayFileContent($filePath, $fileName)
{
    if (file_exists($filePath)) {
        echo "<h1>Viewing File: " . htmlspecialchars($fileName) . "</h1>";
        $fileContents = htmlspecialchars(file_get_contents($filePath)); // Ensure special characters are escaped
        echo "<pre><code class='language-css'>{$fileContents}</code></pre>";
    } else {
        echo "<p>File not found.</p>";
    }
}

function displayEditDeleteOptions($projectUser, $project, $fileName, $currentUser)
{
    if ($projectUser === 'guest' || $projectUser === $currentUser ) {
        echo "<p>
                <a class='defaultLink' href='edit_file.php?user=" . urlencode($projectUser) . "&project=" . urlencode($project) . "&file=" . urlencode($fileName) . "'>Edit</a> 
                <a class='defaultLink' href='delete_file.php?user=" . urlencode($projectUser) . "&project=" . urlencode($project) . "&file=" . urlencode($fileName) . "' onclick=\"return confirm('Are you sure you want to delete this file?');\">Delete</a>
              </p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View File</title>
</head>

<body>

<?php include 'navMenu.php'; ?>

    <a class="defaultLink" href="<?= htmlspecialchars($file_list_link) ?>">Back</a>

    <?php if ($file): ?>
        <?php

        displayEditDeleteOptions($projectUser, $project, $file, $currentUser);
        displayFileContent($filePath, $file);
       
        ?>
    <?php else: ?>
        <p>No user, project, or file specified.</p>
    <?php endif; ?>

</body>

</html>