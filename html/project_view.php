<?php
session_start();

// Sanitize input
$username = isset($_GET['user']) ? urlencode($_GET['user']) : 'guest';
$projectName = isset($_GET['project']) ? urlencode($_GET['project']) : 'defaultProject';
$directory = "uploads/$username/$projectName/";
$previewImagePath = glob($directory . "preview.*");
$errorMessage = "";

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['preview_image'])) {
    $errorMessage = uploadPreview($directory);
}

// Handle project renaming
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_project_name'])) {
    renameProject($directory, $username);
}
function uploadPreview($directory)
{
    $targetDir = $directory;

    // Get the original file extension
    $imageFileType = strtolower(pathinfo($_FILES['preview_image']['name'], PATHINFO_EXTENSION));

    // Set the target file name to preview.<extension>
    $targetFile = $targetDir . 'preview.' . $imageFileType;

    // Check if the uploaded file is a valid image
    $check = getimagesize($_FILES['preview_image']['tmp_name']);
    if ($check !== false) {
        // Check file size (limit to 2MB here)
        if ($_FILES['preview_image']['size'] > 2000000) {
            $errorMessage = "Sorry, your file is too large.";
        } else {
            // Allow certain file formats
            if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                // Create the target directory if it doesn't exist
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Attempt to move the uploaded file
                if (move_uploaded_file($_FILES['preview_image']['tmp_name'], $targetFile)) {
                    $errorMessage = "Preview file uploaded successfully";
                } else {
                    $errorMessage = "Sorry, there was an error uploading your file.";
                }
            } else {
                $errorMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        }
    } else {
        $errorMessage = "File is not an image.";
    }
    return $errorMessage;
}

function renameProject($directory, $username)
{
    $newProjectName = trim($_POST['new_project_name']);

    // Validate new project name (simple check)
    if (!empty($newProjectName) && preg_match('/^[a-zA-Z0-9_\-]+$/', $newProjectName)) {
        $newProjectDir = "uploads/$username/$newProjectName/";

        // Check if the new project name already exists
        if (!is_dir($newProjectDir)) {
            // Rename the project directory
            if (rename($directory, $newProjectDir)) {
                // Redirect to the same page with updated project name
                header("Location: project_view.php?user=" . urlencode($username) . "&project=" . urlencode($newProjectName));
                exit;
            } else {
                echo "<p>Error: Could not rename project directory.</p>";
            }
        } else {
            echo "<p>Error: A project with that name already exists.</p>";
        }
    } else {
        echo "<p>Error: Invalid project name.</p>";
    }
}

function findIndexFile($directory, $htmlFiles)
{
    $validFiles = ['index.html', 'welcome.html', 'home.html', 'intro.html'];

    foreach ($htmlFiles as $file) {
        $filename = basename($file);
        if (in_array(strtolower($filename), $validFiles)) {
            return $file;
        }
    }
    return null;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project: <?= htmlspecialchars($projectName) ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>

<body>
    <?php include 'navMenu.php'; ?>

    <?php if (isset($_GET['user']) && isset($_GET['project'])): ?>

        <!-- Rename project section -->
        <?php if ($username === 'guest' || (isset($_SESSION['username']) && $_SESSION['username'] === $username)): ?>
            <div>
            <span style="font-size:30px;" id="project-name-display"><?= htmlspecialchars($projectName) ?></span>
            <input type="text" id="new_project_name" style="display:none;" placeholder="New Project Name" required>
            <button id="edit-button">✏️ Edit</button>
            <button id="confirm-button" style="display:none;">✅ Confirm</button>
            <button id="cancel-button" style="display:none;">❌ Cancel</button>
        </div>
            <script>
                // Pass PHP variables to JavaScript
                const username = <?= json_encode($username) ?>;
                const projectName = <?= json_encode($projectName) ?>;
            </script>
            <script src="script.js" defer></script>
        <?php else: ?>
            <h1 id="project-name-display"><?= htmlspecialchars($projectName) ?></h1>
        <?php endif; ?>

        <?php if (is_dir($directory)): ?>
            <?php
            // Find the starting file (index.html or similar)
            $htmlFiles = glob($directory . '*.html');
            $startFile = findIndexFile($directory, $htmlFiles);

            // If no special file is found, pick a random HTML file
            if ($startFile === null && !empty($htmlFiles)) {
                $startFile = $htmlFiles[array_rand($htmlFiles)];
            }
            ?>
            <div id="main_div">
            <div id="links_container">
                <p><a class="defaultLink" href="<?= htmlspecialchars($startFile) ?>" target="_blank">View Project</a></p>
                <p><a class="defaultLink"
                        href="file_list.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>">View Files
                        in Project</a></p>

            <?php else: ?>
                <p>No files found for user <?= htmlspecialchars($username) ?> in project <?= htmlspecialchars($projectName) ?>.
                </p>
            <?php endif; ?>

            <!-- Link to download the project -->
            <p><a class="defaultLink"
                    href="download_project.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>">Download
                    Project</a></p>

            <!-- Link to delete the project -->
            <?php if ($username === 'guest' || (isset($_SESSION['username']) && $_SESSION['username'] === $username)): ?>
                <p><a class="defaultLink"
                        href="delete_project.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>"
                        onclick="return confirm('Are you sure you want to delete this project?');">Delete Project</a></p>
            <?php endif; ?>

            <!-- Image upload form -->
            <form action="project_view.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>"
                method="POST" enctype="multipart/form-data">
                <input type="file" name="preview_image" id="preview_image" accept="image/*" required style="display: none;">
                <label id="previewBtn" for="preview_image" class="defaultLink">Upload Preview Image</label>
                <input id="previewSubmit" type="submit" value="Upload Preview Image" style="display: none;">
                <label> <?php if (!empty($errorMessage))
                    echo $errorMessage; ?> </label> <br>
            </form>

            <img class="icon" src="images/delete.png">
            <img class="icon" src="images/download.webp">
        </div>

        <div id="project_view_preview_div">
            <a href="<?= htmlspecialchars($startFile) ?>">
                <img id="project_view_preview" src="<?= $previewImagePath[0] ?>">
                </a>
            </div>
            </div>

    <?php else: ?>
        <p>No user or project specified.</p>
    <?php endif; ?>

</body>

</html>