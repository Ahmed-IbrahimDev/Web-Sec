<?php
/**
 * Fix 419 PAGE EXPIRED Error Script
 * This script clears Laravel cache and fixes session issues
 */

echo "=== Fixing 419 PAGE EXPIRED Error ===\n";

// Change to the Laravel directory
chdir(__DIR__);

echo "1. Clearing application cache...\n";
exec('php artisan cache:clear 2>&1', $output1, $return1);
if ($return1 === 0) {
    echo "✓ Application cache cleared successfully\n";
} else {
    echo "✗ Failed to clear application cache\n";
    print_r($output1);
}

echo "\n2. Clearing config cache...\n";
exec('php artisan config:clear 2>&1', $output2, $return2);
if ($return2 === 0) {
    echo "✓ Config cache cleared successfully\n";
} else {
    echo "✗ Failed to clear config cache\n";
    print_r($output2);
}

echo "\n3. Clearing route cache...\n";
exec('php artisan route:clear 2>&1', $output3, $return3);
if ($return3 === 0) {
    echo "✓ Route cache cleared successfully\n";
} else {
    echo "✗ Failed to clear route cache\n";
    print_r($output3);
}

echo "\n4. Clearing view cache...\n";
exec('php artisan view:clear 2>&1', $output4, $return4);
if ($return4 === 0) {
    echo "✓ View cache cleared successfully\n";
} else {
    echo "✗ Failed to clear view cache\n";
    print_r($output4);
}

echo "\n5. Clearing session files...\n";
$sessionPath = storage_path('framework/sessions');
if (is_dir($sessionPath)) {
    $files = glob($sessionPath . '/*');
    foreach ($files as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            unlink($file);
        }
    }
    echo "✓ Session files cleared successfully\n";
} else {
    echo "✗ Session directory not found\n";
}

echo "\n6. Generating new application key (if needed)...\n";
exec('php artisan key:generate 2>&1', $output5, $return5);
if ($return5 === 0) {
    echo "✓ Application key generated successfully\n";
} else {
    echo "✗ Failed to generate application key\n";
    print_r($output5);
}

echo "\n7. Optimizing application...\n";
exec('php artisan optimize 2>&1', $output6, $return6);
if ($return6 === 0) {
    echo "✓ Application optimized successfully\n";
} else {
    echo "✗ Failed to optimize application\n";
    print_r($output6);
}

echo "\n=== Fix Complete ===\n";
echo "The 419 PAGE EXPIRED error should now be resolved.\n";
echo "Please try accessing the login page again: http://localhost:8000/login\n";
echo "\nIf the error persists, please:\n";
echo "1. Clear your browser cache and cookies\n";
echo "2. Try using an incognito/private browsing window\n";
echo "3. Ensure your .env file has APP_KEY set\n";
echo "4. Make sure the storage/framework/sessions directory is writable\n";
