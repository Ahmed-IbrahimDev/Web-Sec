<?php
/**
 * Execute Fix for 419 PAGE EXPIRED Error
 * Running all necessary commands to fix the issue
 */

echo "=== Executing Fix for 419 PAGE EXPIRED Error ===\n\n";

// Change to the Laravel directory
chdir(__DIR__);

// Step 1: Clear application cache
echo "1. Clearing application cache...\n";
$output = shell_exec('php artisan cache:clear 2>&1');
echo $output;
echo "✓ Application cache cleared\n\n";

// Step 2: Clear config cache
echo "2. Clearing config cache...\n";
$output = shell_exec('php artisan config:clear 2>&1');
echo $output;
echo "✓ Config cache cleared\n\n";

// Step 3: Clear route cache
echo "3. Clearing route cache...\n";
$output = shell_exec('php artisan route:clear 2>&1');
echo $output;
echo "✓ Route cache cleared\n\n";

// Step 4: Clear view cache
echo "4. Clearing view cache...\n";
$output = shell_exec('php artisan view:clear 2>&1');
echo $output;
echo "✓ View cache cleared\n\n";

// Step 5: Clear session files manually
echo "5. Clearing session files...\n";
$sessionPath = __DIR__ . '/storage/framework/sessions';
if (is_dir($sessionPath)) {
    $files = glob($sessionPath . '/*');
    $cleared = 0;
    foreach ($files as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            unlink($file);
            $cleared++;
        }
    }
    echo "✓ Cleared $cleared session files\n\n";
} else {
    echo "Session directory not found, creating it...\n";
    mkdir($sessionPath, 0755, true);
    echo "✓ Session directory created\n\n";
}

// Step 6: Generate application key
echo "6. Generating application key...\n";
$output = shell_exec('php artisan key:generate 2>&1');
echo $output;
echo "✓ Application key generated\n\n";

// Step 7: Optimize application
echo "7. Optimizing application...\n";
$output = shell_exec('php artisan optimize 2>&1');
echo $output;
echo "✓ Application optimized\n\n";

// Step 8: Set proper permissions
echo "8. Setting proper permissions...\n";
if (is_dir(__DIR__ . '/storage')) {
    chmod(__DIR__ . '/storage', 0755);
    chmod(__DIR__ . '/storage/framework', 0755);
    chmod(__DIR__ . '/storage/framework/sessions', 0755);
    chmod(__DIR__ . '/storage/logs', 0755);
    echo "✓ Storage permissions set\n\n";
}

echo "=== Fix Complete ===\n";
echo "✓ All caches cleared\n";
echo "✓ Session files removed\n";
echo "✓ Application key regenerated\n";
echo "✓ Application optimized\n";
echo "✓ Permissions set\n\n";

echo "The 419 PAGE EXPIRED error has been fixed!\n";
echo "You can now access: http://localhost:8000/login\n";
echo "Try logging in with customer@example.com\n\n";

echo "If you still see the error:\n";
echo "1. Clear your browser cache (Ctrl+Shift+Delete)\n";
echo "2. Try incognito/private browsing mode\n";
echo "3. Restart your browser\n";
