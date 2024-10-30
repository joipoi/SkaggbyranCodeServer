<?php
session_start();

// Sanitize input
$user = isset($_GET['user']) ? urlencode($_GET['user']) : 'guest';
$project = isset($_GET['project']) ? urlencode($_GET['project']) : 'defaultProject';
$file = isset($_GET['file']) ? $_GET['file'] : '';

// Create the link to file_list.php
$file_list_link = "file_list.php?user=$user&project=$project";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Include Highlight.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/default.min.css">

<!-- Include Highlight.js JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
<script>hljs.highlightAll();</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View File</title>
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

    <a href="<?= htmlspecialchars($file_list_link) ?>">Back</a>

    <?php if ($file): ?>
        <?php
        $username = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['user']);
        $projectName = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['project']);
        $fileName = preg_replace('/[^a-zA-Z0-9_.-]/', '', $file);
        $filePath = "uploads/$username/$projectName/$fileName";

        if (file_exists($filePath)): ?>
            <h1>Viewing File: <?= htmlspecialchars($fileName) ?></h1>
<?php
// Assuming you read the file contents into $code
$fileContents = htmlspecialchars(file_get_contents($filePath)); // Ensure special characters are escaped
?>
<pre><code class="language-css"><?php echo $fileContents; ?></code></pre>
            <!-- Check if user is the owner or a guest to show edit/delete options -->
            <?php if ($user === 'guest' || (isset($_SESSION['username']) && $user === $_SESSION['username'])): ?>
                <p>
                    <a href="edit_file.php?user=<?= urlencode($user) ?>&project=<?= urlencode($project) ?>&file=<?= urlencode($fileName) ?>">Edit</a> | 
                    <a href="delete_file.php?user=<?= urlencode($user) ?>&project=<?= urlencode($project) ?>&file=<?= urlencode($fileName) ?>" onclick="return confirm('Are you sure you want to delete this file?');">Delete</a>
                </p>
            <?php endif; ?>
        <?php else: ?>
            <p>File not found.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>No user, project, or file specified.</p>
    <?php endif; ?>

</body>
</html>
