<?php
/**
 * Script to clear Laravel cache before renaming project directory
 * This will remove compiled views and cached files that contain old path references
 */

echo "Starting cache cleanup for project rename...\n";

// Clear compiled views
$viewsPath = __DIR__ . '/storage/framework/views';
if (is_dir($viewsPath)) {
    $files = glob($viewsPath . '/*.php');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✓ Cleared compiled views (" . count($files) . " files)\n";
}

// Clear cached config
$configPath = __DIR__ . '/bootstrap/cache/config.php';
if (file_exists($configPath)) {
    unlink($configPath);
    echo "✓ Cleared cached config\n";
}

// Clear cached routes
$routesPath = __DIR__ . '/bootstrap/cache/routes-v7.php';
if (file_exists($routesPath)) {
    unlink($routesPath);
    echo "✓ Cleared cached routes\n";
}

// Clear cached services
$servicesPath = __DIR__ . '/bootstrap/cache/services.php';
if (file_exists($servicesPath)) {
    unlink($servicesPath);
    echo "✓ Cleared cached services\n";
}

// Clear session files
$sessionPath = __DIR__ . '/storage/framework/sessions';
if (is_dir($sessionPath)) {
    $files = glob($sessionPath . '/*');
    foreach ($files as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            unlink($file);
        }
    }
    echo "✓ Cleared session files\n";
}

// Clear cache files
$cachePath = __DIR__ . '/storage/framework/cache/data';
if (is_dir($cachePath)) {
    $files = glob($cachePath . '/*/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✓ Cleared cache data\n";
}

echo "\n✅ Cache cleanup completed successfully!\n";
echo "You can now safely rename the project directory from:\n";
echo "   WebSec230200064 - Copy (2) - Copy - Copy\n";
echo "to:\n";
echo "   WebSec230200064\n\n";
echo "After renaming, run 'php artisan config:cache' to rebuild cache.\n";
