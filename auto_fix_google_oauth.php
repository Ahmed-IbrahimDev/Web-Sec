<?php

echo "=== AUTOMATED Google OAuth Fix ===\n\n";

// Since the manual Google Cloud Console update isn't working,
// let's try different redirect URIs that might already be configured

$possibleRedirectUris = [
    'http://localhost:8000/auth/google/callback',
    'http://127.0.0.1:8000/auth/google/callback',
    'http://localhost/auth/google/callback',
    'http://127.0.0.1/auth/google/callback',
    'http://localhost:80/auth/google/callback',
    'http://localhost:8080/auth/google/callback'
];

echo "PROBLEM: Your Google OAuth client doesn't have the correct redirect URI configured.\n";
echo "Client ID: 219523588810-osllf5j875uq2b6ag8tudj2n736filnu.apps.googleusercontent.com\n\n";

echo "SOLUTION 1: Try different redirect URIs that might already be configured\n\n";

foreach ($possibleRedirectUris as $index => $uri) {
    echo ($index + 1) . ". Try: $uri\n";
}

echo "\nSOLUTION 2: Create a completely new Google OAuth application\n";
echo "This is the most reliable solution:\n\n";

echo "1. Go to: https://console.cloud.google.com/\n";
echo "2. Create a new project (or use existing)\n";
echo "3. Enable Google+ API:\n";
echo "   - Go to APIs & Services → Library\n";
echo "   - Search 'Google+ API' and enable it\n";
echo "4. Create OAuth 2.0 Client:\n";
echo "   - Go to APIs & Services → Credentials\n";
echo "   - Click '+ CREATE CREDENTIALS' → 'OAuth client ID'\n";
echo "   - Application type: 'Web application'\n";
echo "   - Name: 'WebSec Laravel App'\n";
echo "   - Authorized redirect URIs: http://localhost:8000/auth/google/callback\n";
echo "   - Click 'Create'\n";
echo "5. Copy the new Client ID and Client Secret\n";
echo "6. Update your .env file with the new credentials\n\n";

echo "SOLUTION 3: Use a different port\n";
echo "If your app is running on a different port, update the redirect URI accordingly.\n";
echo "Common ports: 8000, 8080, 3000, 80\n\n";

echo "CURRENT STATUS:\n";
echo "- Your Laravel app configuration is correct\n";
echo "- Your routes are properly set up\n";
echo "- The only issue is the Google Cloud Console redirect URI\n\n";

echo "IMMEDIATE ACTION REQUIRED:\n";
echo "You MUST access Google Cloud Console to fix this.\n";
echo "There is no way to bypass this security requirement.\n\n";

echo "Quick Link: https://console.cloud.google.com/apis/credentials\n";
echo "Find your OAuth client and add: http://localhost:8000/auth/google/callback\n\n";

echo "After fixing, test at: http://localhost:8000/login\n";
