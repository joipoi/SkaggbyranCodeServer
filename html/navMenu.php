<?php
session_start();
$user = isset($_SESSION['username']) ? $_SESSION['username'] : 'guest';
?>
<nav id="mainNavMenu">
    <ul>
        <li>
            <img src="https://download.logo.wine/logo/Raspberry_Pi/Raspberry_Pi-Logo.wine.png" height="56px" alt="Raspberry Pi Logo">
        </li>
        <li><a href="index.php">Upload A Project</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="projects.php">View All Projects</a></li>
        <li id="loggedInMessage">Logged in as: <?php echo htmlspecialchars($user); ?></li>
        <li>
            <a href="logout.php" style="color: #eee;" title="Logout">
                <span class="material-symbols-outlined">logout</span>
            </a>
        </li>
    </ul>
</nav>