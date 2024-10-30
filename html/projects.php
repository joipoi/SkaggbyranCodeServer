<?php
// projects.php
$baseDir = 'uploads/';
$userDirs = array_filter(glob($baseDir . '*'), 'is_dir'); // Get all user directories

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Projects</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to a CSS file if needed -->
</head>
<body>

    <h1>User Projects</h1>
    <nav>
        <p>
            <a href="index.php">Upload A Project</a> | 
            <a href="login.php">Login</a> | 
            <a href="register.php">Register</a>
        </p>
    </nav>

    <?php if (empty($userDirs)): ?>
        <p>No user projects found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($userDirs as $userDir): ?>
                <?php $username = basename($userDir); ?>
                <li><strong><?= htmlspecialchars($username) ?></strong>
                    <?php
                    // Get all project folders for this user
                    $projectDirs = array_filter(glob($userDir . '/*'), 'is_dir');

                    if (!empty($projectDirs)): ?>
                        <ul>
                            <?php foreach ($projectDirs as $projectDir): ?>
                                <?php $projectName = basename($projectDir); ?>
                                <li>
                                    <a href="project_view.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>">
                                        <?= htmlspecialchars($projectName) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <ul><li>No projects found.</li></ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</body>
</html>