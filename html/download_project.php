<?php
session_start();

$user = isset($_GET['user']) ? $_GET['user'] : 'guest';
$project = isset($_GET['project']) ? $_GET['project'] : 'defaultProject';

$projectDir = "uploads/$user/$project";

// Check if the project directory exists
if (is_dir($projectDir)) {
    // Create a ZIP file
    $zip = new ZipArchive();
    $zipFileName = "$project.zip";

    if ($zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        // Add files to the ZIP file
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($projectDir));
        
        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
		$relativePath = substr($filePath, strlen($projectDir));
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
} else {
    echo "Project does not exist.";
}
?>
