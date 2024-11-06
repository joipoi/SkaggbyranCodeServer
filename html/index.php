<?php
 if(!isset($_SESSION)) 
 { 
     session_start(); 
 }
$user = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <title>Upload A Frontend Project</title>
</head>

<body>
<?php include 'navMenu.php'; ?>

    <h1>Upload A Frontend Project</h1>

    <?php
    $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'guest';
    $welcomeMessage = isset($_SESSION['username']) ? "Welcome $username!" : "Please log in to upload files. You can also upload as a guest.";
    $uploadButtonText = isset($_SESSION['username']) ? "Upload" : "Upload as Guest";
    ?>

    <p id="welcome"><?= $welcomeMessage ?></p>

    <form action="upload.php" method="POST" enctype="multipart/form-data" class="formWrap">
        <label for="projectname">Name your project then select files:</label><br>
        <input type="text" name="projectname" placeholder="Project Name" required>

        <input type="hidden" name="username" value="<?= $username ?>">

        <label for="fileInput" class="fileButton">Select files</label>
        <input type="file" id="fileInput" name="files[]" multiple required style="display: none;">
        <div id="fileList">
        </div>
        <button type="submit" class="submitBtn"><?= $uploadButtonText ?></button>
    </form>

</body>

</html>