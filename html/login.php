<?php
// login.php

session_start();

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
    $password = $_POST['password'];

    // Check credentials
    $stmt = $conn->prepare("SELECT password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username; // Store username in session
            header("Location: index.php"); // Redirect to upload page
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
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
    <script src="script.js"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <title>Login</title>
</head>

<body>
<?php include 'navMenu.php'; ?>

    <h1>Login</h1>
    <form action="login.php" method="POST" class="formWrap">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <input class="submitBtn" type="submit" value="Login">
        <a href="register.php">Don't have an account? Register</a>
    </form>
</body>

</html>