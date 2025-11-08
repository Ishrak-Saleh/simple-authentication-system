<?php
// Cleanup script for orphaned images
require __DIR__ . '/../vendor/autoload.php';

use app\Models\Post;

echo "<h2>Cleaning up orphaned images...</h2>";

$uploadDir = __DIR__ . '/uploads/';
$files = scandir($uploadDir);

// Get all image paths currently in use in the database
$posts = Post::getAllWithUsers();
$usedImages = [];

foreach ($posts as $post) {
    if ($post['image_path']) {
        $filename = basename($post['image_path']);
        $usedImages[$filename] = true;
    }
}

echo "<p>Found " . count($usedImages) . " images in use in database</p>";

$deletedCount = 0;
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        if (!isset($usedImages[$file])) {
            $filepath = $uploadDir . $file;
            if (unlink($filepath)) {
                echo "<p>Deleted orphaned image: $file</p>";
                $deletedCount++;
            } else {
                echo "<p style='color: red;'>Failed to delete: $file</p>";
            }
        }
    }
}

echo "<h3>Cleanup complete! Deleted $deletedCount orphaned images.</h3>";
?>