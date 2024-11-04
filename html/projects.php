<?php
session_start();
$user = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';

$baseDir = 'uploads/';
$userDirs = array_filter(glob($baseDir . '*'), 'is_dir'); // Get all user directories
$usernames = array_map('basename', $userDirs); // Extract usernames

// Handle filtering
$selectedUser = isset($_GET['filter_user']) ? $_GET['filter_user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Projects</title>
</head>
<body>

    <h1>User Projects</h1>
    <h2>Logged in as: <?php echo $user; ?> </h2>
    <nav>
        <p>
            <a href="index.php">Upload A Project</a> |
            <a href="login.php">Login</a> |
            <a href="register.php">Register</a>
        </p>
    </nav>

<!-- Filter form -->
<form method="GET" action="projects.php" id="filter-form">
    <label for="filter_user">Filter by User:</label>
    <select name="filter_user" id="filter_user" onchange="document.getElementById('filter-form').submit();">
        <option value="">All Users</option>
        <?php foreach ($usernames as $username): ?>
            <option value="<?= htmlspecialchars($username) ?>" <?= ($selectedUser === $username) ? 'selected' : '' ?>>
                <?= htmlspecialchars($username) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <!-- Removed the submit button -->
</form>

<?php listProjects($userDirs, $selectedUser); ?>
 

</body>
</html>

    <?php
function listProjects($userDirs, $selectedUser) {
    // Filter user directories based on selection
    if ($selectedUser) {
        $userDirs = array_filter($userDirs, function ($dir) use ($selectedUser) {
            return basename($dir) === $selectedUser;
        });
    }

    if (empty($userDirs)): ?>
        <p>No user projects found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($userDirs as $userDir): ?>
                <?php $username = basename($userDir); ?>
                <li><strong><?= htmlspecialchars($username) ?></strong>
                    <?php displayProjects($userDir, $username); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif;
}

function displayProjects($userDir, $username) {
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
                    <?php displayPreviewImage($projectDir, $projectName); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <ul><li>No projects found.</li></ul>
    <?php endif;
}

function displayPreviewImage($projectDir, $projectName) {
    // Check for the preview image with multiple extensions
    $extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $imageFound = false;

    foreach ($extensions as $extension) {
        $previewImagePath = $projectDir . '/preview.' . $extension;
        if (file_exists($previewImagePath)) {
            echo '<img src="' . htmlspecialchars($previewImagePath) . '" alt="Preview of ' . htmlspecialchars($projectName) . '" style="width: 400px; height: auto;">';
            $imageFound = true;
            break; // Exit the loop once the image is found
        }
    }

    if (!$imageFound) {
        echo '<span>No preview available</span>';
    }
}



