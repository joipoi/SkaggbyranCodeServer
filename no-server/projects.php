<?php
// projects.php
$baseDir = 'uploads/';
$userDirs = array_filter(glob($baseDir . '*'), 'is_dir'); // Get all user directories

echo "<h1>User Projects</h1>";
echo '<p> <a href="index.php">Upload A Project</a> | <a href="login.php">Login</a> | <a href="register.php">Register</a>  </p>';
if (empty($userDirs)) {
    echo "<p>No user projects found.</p>";
} else {
    echo "<ul>";
    foreach ($userDirs as $userDir) {
        $username = basename($userDir);
        echo "<li><strong>" . htmlspecialchars($username) . "</strong>";
        
        // Get all project folders for this user
        $projectDirs = array_filter(glob($userDir . '/*'), 'is_dir');
        
        if (!empty($projectDirs)) {
            echo "<ul>";
            foreach ($projectDirs as $projectDir) {
                $projectName = basename($projectDir);
		// Create a clickable link for the project
echo "<li><a href='project_view.php?user=" . urlencode($username) . "&project=" . urlencode($projectName) . "'>" . htmlspecialchars($projectName) . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<ul><li>No projects found.</li></ul>";
        }
        
        echo "</li>";
    }
    echo "</ul>";
}
?>
