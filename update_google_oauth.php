<?php

echo "=== Google OAuth Configuration Helper ===\n\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "Error: .env file not found!\n";
    exit(1);
}

echo "INSTRUCTIONS:\n";
echo "1. Go to Google Cloud Console: https://console.cloud.google.com/\n";
echo "2. Create a new project or select existing one\n";
echo "3. Enable Google+ API (or Google Identity API)\n";
echo "4. Go to 'Credentials' -> 'Create Credentials' -> 'OAuth 2.0 Client IDs'\n";
echo "5. Set application type to 'Web application'\n";
echo "6. Add authorized redirect URI: http://127.0.0.1:8000/auth/google/callback\n";
echo "7. Copy the Client ID and Client Secret\n\n";

echo "Enter your Google OAuth credentials:\n";

// Get user input
echo "Google Client ID: ";
$clientId = trim(fgets(STDIN));

echo "Google Client Secret: ";
$clientSecret = trim(fgets(STDIN));

if (empty($clientId) || empty($clientSecret)) {
    echo "Error: Both Client ID and Client Secret are required!\n";
    exit(1);
}

// Read current .env content
$envContent = file_get_contents('.env');

// Remove existing Google OAuth configuration if present
$envContent = preg_replace('/# Google OAuth Configuration.*?\n/s', '', $envContent);
$envContent = preg_replace('/GOOGLE_CLIENT_ID=.*?\n/', '', $envContent);
$envContent = preg_replace('/GOOGLE_CLIENT_SECRET=.*?\n/', '', $envContent);
$envContent = preg_replace('/GOOGLE_REDIRECT_URI=.*?\n/', '', $envContent);

// Add new Google OAuth configuration
$googleConfig = "\n# Google OAuth Configuration\n";
$googleConfig .= "GOOGLE_CLIENT_ID=" . $clientId . "\n";
$googleConfig .= "GOOGLE_CLIENT_SECRET=" . $clientSecret . "\n";
$googleConfig .= "GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback\n";

// Write updated content back to .env
file_put_contents('.env', $envContent . $googleConfig);

echo "\n✅ Google OAuth configuration updated successfully!\n";
echo "You can now test the Google OAuth login.\n\n";

echo "To start your Laravel server, run:\n";
echo "php artisan serve\n\n";

echo "Then visit: http://127.0.0.1:8000/auth/google\n";
