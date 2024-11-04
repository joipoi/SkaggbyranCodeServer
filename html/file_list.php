<?php
// file_list.php

// Sanitize input
$username = isset($_GET['user']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['user']) : null;
$projectName = isset($_GET['project']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['project']) : null;
$directory = "uploads/$username/$projectName/";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File List</title>
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

    <?php if ($username && $projectName && is_dir($directory)): ?>
        <h1>Files in Project: <?= htmlspecialchars($projectName) ?></h1>
        <?php
        $files = glob($directory . '*');
        if (empty($files)): ?>
            <p>No files found in this project.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($files as $file): ?>
                    <?php if (is_file($file)): ?>
                        <?php $fileName = basename($file); ?>
                        <li>
                            <a href="<?= htmlspecialchars($file) ?>" target="_blank"><?= htmlspecialchars($fileName) ?></a> - 
                            <a href="view_file.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>&file=<?= urlencode($fileName) ?>">View Contents</a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php else: ?>
        <p>No user or project specified, or no files found for user <?= htmlspecialchars($username) ?> in project <?= htmlspecialchars($projectName) ?>.</p>
    <?php endif; ?>
 <p><a href="project_view.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>">Back To Project</a></p>

</body>
</html>
