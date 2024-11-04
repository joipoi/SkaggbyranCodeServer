<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <title>Upload A Frontend Project</title>
</head>
<body>
<nav>
   <ul>
		<li><img src="https://download.logo.wine/logo/Raspberry_Pi/Raspberry_Pi-Logo.wine.png" height="56px"></li>
  <li><a href="index.php">Upload A Project</a></li>   
 <li><a href="login.php">Login</a></li>
      <li><a href="register.php">Register</a></li>
      <li><a href="projects.php">View All Projects</a</li>
      <li><a href="logout.php" style="color: #eee;"></a>
			<span class="material-symbols-outlined">logout</span>
		</li>
   </ul>
</nav>

    <h1>Upload A Frontend Project</h1>

<?php
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'guest';
$welcomeMessage = isset($_SESSION['username']) ? "Welcome $username!" : "Please log in to upload files. You can also upload as a guest.";
$uploadButtonText = isset($_SESSION['username']) ? "Upload" : "Upload as Guest";
?>

<p id="welcome"><?= $welcomeMessage ?></p>

<form action="upload.php" method="POST" enctype="multipart/form-data" id="formWrap">
    <label for="projectname">Name your project then select files:</label><br>
    <input type="text" name="projectname" placeholder="Project Name" required>
    
    <input type="hidden" name="username" value="<?= $username ?>">
    
    <label for="files[]" class="fileButton">Select files</label>
    <input type="file" name="files[]" webkitdirectory multiple required>
    
    <button type="submit" id="uploadBtn"><?= $uploadButtonText ?></button>
</form>

</body>
</html>
