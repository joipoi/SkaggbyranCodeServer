<?php
session_start();

$projectUser = isset($_GET['user']) ? $_GET['user'] : 'guest';
$project = isset($_GET['project']) ? $_GET['project'] : 'defaultProject';
$file = isset($_GET['file']) ? $_GET['file'] : '';

$projectDir = "uploads/$projectUser/$project/$file";

// Check if the file exists
if (!file_exists($projectDir)) {
    die("File does not exist.");
}

// Handle file editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newContent = $_POST['content'];
    file_put_contents($projectDir, $newContent);
    #echo "File updated successfully. <a href='view_file.php?projectUser=" . urlencode($user) . "&project=" . urlencode($project) . "'>Go back</a>";
    $file_list_link = "file_list.php?user=$projectUser&project=$project";
    header("Location: $file_list_link");
    exit();
}

// Read file content for editing
$content = file_get_contents($projectDir);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <meta charset="UTF-8">
    <title>Edit File</title>
</head>

<body>
<?php include 'navMenu.php'; ?>
    <h1>Edit File: <?= htmlspecialchars($file) ?></h1>
    <form
        action="edit_file.php?user=<?= urlencode($projectUser) ?>&project=<?= urlencode($project) ?>&file=<?= urlencode($file) ?>"
        method="POST">
        <textarea id="editTextArea" name="content" rows="20" cols="80"><?= htmlspecialchars($content) ?></textarea><br>
        <input type="submit" value="Save Changes">
    </form>
    <p><a class="defaultLink"
            href="view_file.php?user=<?= urlencode($projectUser) ?>&project=<?= urlencode($project) ?>&file=<?= urlencode($file) ?>">
           <span id="cancel"> Cancel </span> <span class="material-symbols-outlined icon1">
cancel
</span>
        </a>
    </p>
</body>

</html>