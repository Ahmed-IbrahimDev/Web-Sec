<?php
// Execute fix immediately
echo "Starting fix execution...\n";

// Clear all Laravel caches
system('php artisan cache:clear');
system('php artisan config:clear'); 
system('php artisan route:clear');
system('php artisan view:clear');

// Clear session files
$sessionDir = __DIR__ . '/storage/framework/sessions';
if (is_dir($sessionDir)) {
    $files = glob($sessionDir . '/*');
    foreach ($files as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            unlink($file);
        }
    }
}

// Generate new app key
system('php artisan key:generate');

// Optimize
system('php artisan optimize');

echo "Fix completed! Try http://localhost:8000/login now\n";
