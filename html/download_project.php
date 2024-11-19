<?php
session_start();

// Get user and project information
$projectUser = isset($_GET['user']) ? $_GET['user'] : 'guest';
$project = isset($_GET['project']) ? $_GET['project'] : 'defaultProject';

$projectDir = "uploads/$projectUser/$project";
// Check if the project directory exists
if (is_dir($projectDir)) {
    downloadProjectAsZip($projectDir, "/tmp/$project.zip", $projectUser);
} else {
    echo "Project does not exist.";
}

/**
 * Create a ZIP file from the specified directory and initiate the download.
 *
 * @param string $directory The directory to compress.
 * @param string $zipFileName The name of the ZIP file to create.
 */
function downloadProjectAsZip($directory, $zipFileName, $projectUser) {
    $zip = new ZipArchive();

    if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        $fileAdded = false; // Track if any files are added

        foreach ($files as $file) {
            if (!$file->isDir()) {
		    $filePath = $file->getRealPath();
		   $uploadsPath = "/var/www/SkaggbyranCodeServer/html/uploads";
                $relativePath = str_replace("$uploadsPath/$projectUser/", '', $filePath);
                error_log("file path = $filePath"); // Log error
                error_log("relative path = $relativePath");
                if ($zip->addFile($filePath, $relativePath)) {
                    $fileAdded = true; // Mark that a file was added
                } else {
                    error_log("Failed to add file: $filePath"); // Log error
                }
            }
        }

        if ($fileAdded) {
            $zip->close();
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
            header('Content-Length: ' . filesize($zipFileName));
            readfile($zipFileName);
            unlink($zipFileName);
            exit();
        } else {
            $zip->close();
            echo "No files were added to the ZIP.";
        }
    } else {
        echo "Could not create ZIP file.";
    }
}
?>
