<?php

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

    // Validate username
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $errorMessage = "Username must be 3-20 characters long and can only contain letters, numbers, and underscores.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errorMessage = "Username already exists.";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $password);
            if ($stmt->execute()) {
                $errorMessage = "Registration successful!";
            } else {
                $errorMessage = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
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
    <title>Register</title>
</head>
<body>
<?php include 'navMenu.php'; ?>
    <h1>Register</h1>
    <form action="register.php" method="POST" class="formWrap">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <input class="submitBtn" type="submit" value="Register">
        <label><?php if (!empty($errorMessage)) echo $errorMessage; ?></label> <br>
        <a href="login.php">Already have an account? Log in</a>  
    </form>
</body>
</html>