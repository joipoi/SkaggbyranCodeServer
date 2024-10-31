<?php
session_start(); // Ensure session is started for user authentication

// Sanitize input
$username = isset($_GET['user']) ? urlencode($_GET['user']) : 'guest';
$projectName = isset($_GET['project']) ? urlencode($_GET['project']) : 'defaultProject';
$directory = "uploads/$username/$projectName/";

// Handle image upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['preview_image'])) {
    $targetDir = $directory; // Ensure this is set correctly

    // Get the original file extension
    $imageFileType = strtolower(pathinfo($_FILES['preview_image']['name'], PATHINFO_EXTENSION));

    // Set the target file name to preview.<extension>
    $targetFile = $targetDir . 'preview.' . $imageFileType;

    // Check if the uploaded file is a valid image
    $check = getimagesize($_FILES['preview_image']['tmp_name']);
    if ($check !== false) {
        // Check file size (limit to 2MB here)
        if ($_FILES['preview_image']['size'] > 2000000) {
            echo "Sorry, your file is too large.";
        } else {
            // Allow certain file formats
            if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                // Create the target directory if it doesn't exist
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Attempt to move the uploaded file
                if (move_uploaded_file($_FILES['preview_image']['tmp_name'], $targetFile)) {
                    echo "The file has been uploaded as " . htmlspecialchars($targetFile);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        }
    } else {
        echo "File is not an image.";
    }
}

// Handle project renaming
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_project_name'])) {
    $newProjectName = trim($_POST['new_project_name']);
    
    // Validate new project name (simple check)
    if (!empty($newProjectName) && preg_match('/^[a-zA-Z0-9_\-]+$/', $newProjectName)) {
        $newProjectDir = "uploads/$username/$newProjectName/";

        // Check if the new project name already exists
        if (!is_dir($newProjectDir)) {
            rename($directory, $newProjectDir);
            // Update the directory variable
            $directory = $newProjectDir;
            $projectName = $newProjectName; // Update the project name variable
            echo "<p>Project renamed to " . htmlspecialchars($newProjectName) . " successfully.</p>";
        } else {
            echo "<p>Error: A project with that name already exists.</p>";
        }
    } else {
        echo "<p>Error: Invalid project name.</p>";
    }
}
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

<!-- Rename project section -->
<?php if ($username === 'guest' || (isset($_SESSION['username']) && $_SESSION['username'] === $username)): ?>
    <span style="font-size:30px;" id="project-name-display"><?= htmlspecialchars($projectName) ?></span>
    <input type="text" id="new_project_name" style="display:none;" placeholder="New Project Name" required>
    <button id="edit-button">✏️ Edit</button>
    <button id="confirm-button" style="display:none;">✅ Confirm</button>
    <button id="cancel-button" style="display:none;">❌ Cancel</button>

    <script>
        const editButton = document.getElementById('edit-button');
        const confirmButton = document.getElementById('confirm-button');
        const cancelButton = document.getElementById('cancel-button');
        const projectNameDisplay = document.getElementById('project-name-display');
        const newProjectNameInput = document.getElementById('new_project_name');

        editButton.onclick = function() {
            projectNameDisplay.style.display = 'none';
            newProjectNameInput.style.display = 'inline';
            confirmButton.style.display = 'inline';
            cancelButton.style.display = 'inline';
            newProjectNameInput.value = projectNameDisplay.textContent; // Pre-fill input
        };

        confirmButton.onclick = function() {
            const newProjectName = newProjectNameInput.value.trim();
            if (newProjectName) {
                // Submit the new project name via a form
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'project_view.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'new_project_name';
                input.value = newProjectName;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        };

        cancelButton.onclick = function() {
            projectNameDisplay.style.display = 'inline';
            newProjectNameInput.style.display = 'none';
            confirmButton.style.display = 'none';
            cancelButton.style.display = 'none';
        };
    </script>
<?php else: ?>
    <h2 id="project-name-display"><?= htmlspecialchars($projectName) ?></h2>
<?php endif; ?>

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

        <!-- Image upload form -->
        <h2>Upload a Project Preview Image</h2>
        <form action="project_view.php?user=<?= urlencode($username) ?>&project=<?= urlencode($projectName) ?>" method="POST" enctype="multipart/form-data">
            <label for="preview_image">Choose an image to upload:</label>
            <input type="file" name="preview_image" id="preview_image" accept="image/*" required>
            <input type="submit" value="Upload Image">
        </form>

    <?php else: ?>
        <p>No user or project specified.</p>
    <?php endif; ?>

</body>
</html>
