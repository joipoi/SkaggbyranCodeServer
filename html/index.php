<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Files or Folders</title>
</head>
<body>
    <h1>Upload Files or Folders</h1>

    <?php if (isset($_SESSION['username'])): ?>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
	<form action="upload.php" method="POST" enctype="multipart/form-data">
<label for="projectname">Enter Your Project Name:</label>
        <input type="text" name="projectname" required> <br>
            <input type="hidden" name="username" value="<?= htmlspecialchars($_SESSION['username']) ?>">
            <input type="file" name="files[]" webkitdirectory multiple required>
            <input type="submit" value="Upload">
        </form>
    <?php else: ?>
        <p>Please log in to upload files. You can also upload as a guest.</p>
	<form action="upload.php" method="POST" enctype="multipart/form-data">
<label for="projectname">Enter Your Project Name:</label>
<input type="text" name="projectname" required> <br>
	    <input type="hidden" name="username" value="guest">
<input type="file" name="files[]" multiple required>
            <input type="submit" value="Upload as Guest">
        </form>
    <?php endif; ?>

    <p><a href="login.php">Login</a> | <a href="register.php">Register</a> | <a href="projects.php">View All Projects</a> | <a href="logout.php">Logout</a> </p>
</body>
</html>
