<?php
session_start();

$user = isset($_GET['user']) ? $_GET['user'] : 'guest';
$project = isset($_GET['project']) ? $_GET['project'] : 'defaultProject';
$file = isset($_GET['file']) ? $_GET['file'] : '';

$projectDir = "uploads/$user/$project/$file";

// Check if the file exists
if (!file_exists($projectDir)) {
    die("File does not exist.");
}

// Handle file editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newContent = $_POST['content'];
    file_put_contents($projectDir, $newContent);
    #echo "File updated successfully. <a href='view_file.php?user=" . urlencode($user) . "&project=" . urlencode($project) . "'>Go back</a>";
    $file_list_link = "file_list.php?user=$user&project=$project";
header("Location: $file_list_link");
    exit();
}

// Read file content for editing
$content = file_get_contents($projectDir);
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
    <title>Edit File</title>
</head>
<body>
    <h1>Edit File: <?= htmlspecialchars($file) ?></h1>
    <form action="edit_file.php?user=<?= urlencode($user) ?>&project=<?= urlencode($project) ?>&file=<?= urlencode($file) ?>" method="POST">
        <textarea name="content" rows="20" cols="80"><?= htmlspecialchars($content) ?></textarea><br>
        <input type="submit" value="Save Changes">
    </form>
    <p><a href="view_file.php?user=<?= urlencode($user) ?>&project=<?= urlencode($project) ?>&file=<?= urlencode($file) ?>">Cancel</a></p>
</body>
</html>
