<?php

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
    <link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>
<body>

<?php include 'navMenu.php'; ?>

    <?php if ($username && $projectName && is_dir($directory)): ?>
        <h1>Files in Project: <?= htmlspecialchars($projectName) ?></h1>
        <?php
        $files = glob($directory . '*');
        if (empty($files)): ?>
            <p>No files found in this project.</p>
        <?php else: ?>
            <ul id="fileListUL">
                <?php foreach ($files as $file): ?>
                    <?php if (is_file($file)): ?>
                        <?php $fileName = basename($file); ?>
                        <li>
                            <a class="defaultLink" href="<?= htmlspecialchars($file) ?>" target="_blank"><?= htmlspecialchars($fileName) ?></a> 
                            <a class="defaultLink" href="view_file.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>&file=<?= urlencode($fileName) ?>">View Contents</a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php else: ?>
        <p>No user or project specified, or no files found for user <?= htmlspecialchars($username) ?> in project <?= htmlspecialchars($projectName) ?>.</p>
    <?php endif; ?>
 <p><a class="defaultLink" href="project_view.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>">Back To Project</a></p>

</body>
</html>
