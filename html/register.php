<?php
// register.php

$servername = getenv('DB_SERVER');
$db_username = getenv('DB_USER');
$db_password = getenv('DB_PASS');
$dbname = getenv('DB_NAME');

$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists.";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <title>Register</title>
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
    <h2>Register</h2>
    <form action="register.php" method="POST" class="formWrap">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <input class="submitBtn" type="submit" value="Register">
    </form>
    <p><a href="login.php">Already have an account? Log in</a></p>
</body>
</html>
