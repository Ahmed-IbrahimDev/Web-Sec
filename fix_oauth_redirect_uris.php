<?php

echo "=== OAuth Redirect URI Fix ===\n\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "Error: .env file not found!\n";
    exit(1);
}

echo "Current OAuth Issues:\n";
echo "❌ Google OAuth: redirect_uri_mismatch error\n";
echo "❌ Microsoft OAuth: Authentication failed\n\n";

echo "Google OAuth Error Analysis:\n";
echo "- Current redirect URI: http://localhost:8000/auth/google/callback\n";
echo "- This URI is NOT registered in Google Cloud Console\n";
echo "- Google expects an exact match with registered URIs\n\n";

// Read current .env content
$envContent = file_get_contents('.env');

echo "Fixing Google OAuth redirect URI...\n";

// The most common registered URIs in Google Console are with 127.0.0.1
// Let's try the original URI that was working
$envContent = str_replace(
    'GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback',
    'GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback',
    $envContent
);

echo "✅ Updated Google redirect URI to: http://127.0.0.1:8000/auth/google/callback\n";

// Also ensure Microsoft redirect URI is consistent
$envContent = str_replace(
    'MICROSOFT_REDIRECT_URI=http://localhost:8000/auth/microsoft/callback',
    'MICROSOFT_REDIRECT_URI=http://127.0.0.1:8000/auth/microsoft/callback',
    $envContent
);

echo "✅ Updated Microsoft redirect URI to: http://127.0.0.1:8000/auth/microsoft/callback\n";

// Write updated content back to .env
file_put_contents('.env', $envContent);

echo "\n=== REDIRECT URI FIX COMPLETE ===\n";
echo "Updated both OAuth providers to use 127.0.0.1 instead of localhost\n";
echo "This should match the URIs registered in your OAuth applications.\n\n";

echo "=== NEXT STEPS ===\n";
echo "1. Clear Laravel cache: php artisan config:clear\n";
echo "2. Test Google OAuth: http://127.0.0.1:8000/auth/google\n";
echo "3. Test Microsoft OAuth: http://127.0.0.1:8000/auth/microsoft\n\n";

echo "If Google OAuth still fails, you need to add this URI to Google Cloud Console:\n";
echo "http://127.0.0.1:8000/auth/google/callback\n\n";

echo "If Microsoft OAuth still fails, you need to add this URI to Azure:\n";
echo "http://127.0.0.1:8000/auth/microsoft/callback\n";
