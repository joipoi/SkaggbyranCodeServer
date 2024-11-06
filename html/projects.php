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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <title>User Projects</title>
</head>
<body>
<?php include 'navMenu.php'; ?>
    <h1>User Projects</h1>

<form method="GET" action="projects.php" id="filter-form">
    <select name="filter_user" id="filter_user" onchange="document.getElementById('filter-form').submit();">
        <option value="">All Users</option>
        <?php foreach ($usernames as $username): ?>
            <option value="<?= htmlspecialchars($username) ?>" <?= ($selectedUser === $username) ? 'selected' : '' ?>>
                <?= htmlspecialchars($username) ?>
            </option>
        <?php endforeach; ?>
    </select>
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
            <?php foreach ($userDirs as $userDir): ?>
                <?php $username = basename($userDir); ?>
<h2 class="userName"> <strong><?= htmlspecialchars($username) ?></strong></h2>
                 <div class="projectContainer"> 
                    <?php displayProjects($userDir, $username); ?>
                </div>
            <?php endforeach; ?>
    <?php endif;
}

function displayProjects($userDir, $username) {
    // Get all project folders for this user
    $projectDirs = array_filter(glob($userDir . '/*'), 'is_dir');

    if (!empty($projectDirs)): ?>
            <?php foreach ($projectDirs as $projectDir): ?>
                <?php $projectName = basename($projectDir); ?>
	 <a class="projectName" href="project_view.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>">
<div class="projectDiv">
                      <?= htmlspecialchars($projectName) ?>
		    <?php displayPreviewImage($projectDir, $projectName); ?>
</div>
</a>

            <?php endforeach; ?>
    <?php else: ?>
        No projects found.
    <?php endif;
}

function displayPreviewImage($projectDir, $projectName) {
    // Check for the preview image with multiple extensions
    $extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $imageFound = false;

    foreach ($extensions as $extension) {
        $previewImagePath = $projectDir . '/preview.' . $extension;
        if (file_exists($previewImagePath)) {
            echo '<img class="projectPreview" src="' . htmlspecialchars($previewImagePath) . '" alt="Preview of ' . htmlspecialchars($projectName) . '">';
            $imageFound = true;
            break; // Exit the loop once the image is found
        }
    }

    if (!$imageFound) {
	    echo '<img class="projectPreview" src="images/defaultPreview.png" alt="Preview of ' . htmlspecialchars($projectName) . '">';

    }
}



