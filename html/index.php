<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Folder</title>
</head>
<body>
    <h1>Upload a Folder</h1>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <label for="username">Enter Your Name:</label>
        <input type="text" name="username" required> <br>
        <label for="projectname">Enter Your Project Name:</label> 
        <input type="text" name="projectname" required>

	<input type="file" name="files[]" webkitdirectory multiple required>
        <input type="submit" value="Upload">
    </form>
<a href ="/projects.php">View All Projects </a>
</body>
</html>
