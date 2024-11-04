<?php
session_start();

// Sanitize input
$user = isset($_GET['user']) ? urlencode($_GET['user']) : 'guest';
$project = isset($_GET['project']) ? urlencode($_GET['project']) : 'defaultProject';
$file = isset($_GET['file']) ? $_GET['file'] : '';

// Create the link to file_list.php
$file_list_link = "file_list.php?user=$user&project=$project";

function displayFileContent($filePath, $fileName) {
    if (file_exists($filePath)) {
        echo "<h1>Viewing File: " . htmlspecialchars($fileName) . "</h1>";
        $fileContents = htmlspecialchars(file_get_contents($filePath)); // Ensure special characters are escaped
        echo "<pre><code class='language-css'>{$fileContents}</code></pre>";
    } else {
        echo "<p>File not found.</p>";
    }
}

function displayEditDeleteOptions($user, $project, $fileName) {
    if ($user === 'guest' || (isset($_SESSION['username']) && $user === $_SESSION['username'])) {
        echo "<p>
                <a href='edit_file.php?user=" . urlencode($user) . "&project=" . urlencode($project) . "&file=" . urlencode($fileName) . "'>Edit</a> | 
                <a href='delete_file.php?user=" . urlencode($user) . "&project=" . urlencode($project) . "&file=" . urlencode($fileName) . "' onclick=\"return confirm('Are you sure you want to delete this file?');\">Delete</a>
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View File</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <nav>
        <p>
            <a href="index.php">Upload A Project</a> | 
            <a href="projects.php">View All Projects</a> | 
            <a href="login.php">Login</a> | 
            <a href="register.php">Register</a>
        </p>
    </nav>

    <a href="<?= htmlspecialchars($file_list_link) ?>">Back</a>

    <?php if ($file): ?>
        <?php
        $username = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['user']);
        $projectName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['project']);
        $fileName = preg_replace('/[^a-zA-Z0-9_.-]/', '', $file);
        $filePath = "uploads/$username/$projectName/$fileName";

        displayFileContent($filePath, $fileName);
        displayEditDeleteOptions($user, $project, $fileName);
        ?>
    <?php else: ?>
        <p>No user, project, or file specified.</p>
    <?php endif; ?>

</body>
</html>
