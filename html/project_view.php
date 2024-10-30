<?php
// project.php

// Sanitize input
$username = isset($_GET['user']) ? urlencode($_GET['user']) : 'guest';
$projectName = isset($_GET['project']) ? urlencode($_GET['project']) : 'defaultProject';
$directory = "uploads/$username/$projectName/";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project: <?= htmlspecialchars($projectName) ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to a CSS file if needed -->
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

    <?php if (isset($_GET['user']) && isset($_GET['project'])): ?>
        <h1>Project: <?= htmlspecialchars($projectName) ?></h1>

        <?php if (is_dir($directory)): ?>
            <?php
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
            ?>

            <!-- Display links -->
            <p><a href="<?= htmlspecialchars($startFile) ?>" target="_blank">View Project</a></p>
            <p><a href="file_list.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>">View Files in Project</a></p>

        <?php else: ?>
            <p>No files found for user <?= htmlspecialchars($username) ?> in project <?= htmlspecialchars($projectName) ?>.</p>
        <?php endif; ?>

        <!-- Link to download the project -->
        <p><a href="download_project.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>">Download Project</a></p>

        <!-- Link to delete the project -->
        <?php if ($username === 'guest' || (isset($_SESSION['username']) && $_SESSION['username'] === $username)): ?>
            <p><a href="delete_project.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>" onclick="return confirm('Are you sure you want to delete this project?');">Delete Project</a></p>
        <?php endif; ?>

    <?php else: ?>
        <p>No user or project specified.</p>
    <?php endif; ?>

</body>
</html>