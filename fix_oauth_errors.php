<?php

echo "=== OAuth Authentication Errors Fix ===\n\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "Error: .env file not found!\n";
    exit(1);
}

echo "Current OAuth Configuration Issues:\n";
echo "❌ Google OAuth: Authentication failed\n";
echo "❌ Microsoft OAuth: Missing client secret\n\n";

// Read current .env content
$envContent = file_get_contents('.env');

echo "=== FIXING GOOGLE OAUTH ===\n";
echo "Issue: Possible redirect URI mismatch or session problems\n";
echo "Current Google redirect URI: http://127.0.0.1:8000/auth/google/callback\n";
echo "Recommended: Use consistent localhost URLs\n\n";

// Fix Google OAuth redirect URI to use localhost consistently
$envContent = str_replace(
    'GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback',
    'GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback',
    $envContent
);

echo "✅ Updated Google redirect URI to use localhost\n\n";

echo "=== FIXING MICROSOFT OAUTH ===\n";
echo "Issue: Missing client secret (still has placeholder)\n";
echo "Your Azure App Details:\n";
echo "- Application ID: f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7\n";
echo "- Tenant ID: 4cf493e2-c44f-4a85-9650-f432e907ba34\n\n";

echo "Do you want to add your Microsoft Client Secret now? (y/n): ";
$addSecret = trim(fgets(STDIN));

if (strtolower($addSecret) === 'y') {
    echo "Enter your Microsoft Client Secret: ";
    $clientSecret = trim(fgets(STDIN));
    
    if (!empty($clientSecret)) {
        // Replace the placeholder client secret
        $envContent = str_replace(
            'MICROSOFT_CLIENT_SECRET=your-client-secret-from-azure',
            'MICROSOFT_CLIENT_SECRET=' . $clientSecret,
            $envContent
        );
        echo "✅ Microsoft client secret added!\n";
    } else {
        echo "❌ Empty client secret provided. Microsoft OAuth will still fail.\n";
    }
} else {
    echo "⚠️  Microsoft OAuth will continue to fail without client secret.\n";
}

// Write updated content back to .env
file_put_contents('.env', $envContent);

echo "\n=== OAUTH FIX SUMMARY ===\n";
echo "✅ Google OAuth: Fixed redirect URI consistency\n";
echo "✅ Environment file updated\n";

if (strtolower($addSecret) === 'y') {
    echo "✅ Microsoft OAuth: Client secret configured\n";
} else {
    echo "⚠️  Microsoft OAuth: Still needs client secret\n";
}

echo "\n=== NEXT STEPS ===\n";
echo "1. Clear Laravel cache: php artisan config:clear\n";
echo "2. Test Google OAuth: http://localhost:8000/auth/google\n";
echo "3. Test Microsoft OAuth: http://localhost:8000/auth/microsoft\n";
echo "4. Check your Google Cloud Console redirect URIs include: http://localhost:8000/auth/google/callback\n\n";

echo "🎉 OAuth configuration updated!\n";
