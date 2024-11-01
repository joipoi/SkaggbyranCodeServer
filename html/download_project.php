<?php
session_start();

// Get user and project information
$user = isset($_GET['user']) ? $_GET['user'] : 'guest';
$project = isset($_GET['project']) ? $_GET['project'] : 'defaultProject';

$projectDir = "uploads/$user/$project";

// Check if the project directory exists
if (is_dir($projectDir)) {
    downloadProjectAsZip($projectDir, "$project.zip");
} else {
    echo "Project does not exist.";
}

/**
 * Create a ZIP file from the specified directory and initiate the download.
 *
 * @param string $directory The directory to compress.
 * @param string $zipFileName The name of the ZIP file to create.
 */
function downloadProjectAsZip($directory, $zipFileName) {
    $zip = new ZipArchive();

    if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        // Add files to the ZIP file
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($directory));
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();

        // Set headers to initiate download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipFileName) . '"');
        header('Content-Length: ' . filesize($zipFileName));
        readfile($zipFileName);

        // Delete the ZIP file after download
        unlink($zipFileName);
        exit();
    } else {
        echo "Could not create ZIP file.";
    }
}
?>
