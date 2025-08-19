<?php

echo "=== Microsoft OAuth Configuration Setup ===\n\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "Error: .env file not found!\n";
    exit(1);
}

echo "Your Azure Application Details:\n";
echo "- Application ID: f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7\n";
echo "- Tenant ID: 4cf493e2-c44f-4a85-9650-f432e907ba34\n";
echo "- Redirect URI: http://localhost:8000/auth/microsoft/callback\n\n";

echo "IMPORTANT: You need to create a Client Secret in Azure Portal:\n";
echo "1. Go to Azure Portal -> App registrations\n";
echo "2. Select your application (f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7)\n";
echo "3. Go to 'Certificates & secrets' -> 'Client secrets' -> 'New client secret'\n";
echo "4. Copy the generated secret value\n\n";

echo "Enter your Microsoft Client Secret: ";
$clientSecret = trim(fgets(STDIN));

if (empty($clientSecret)) {
    echo "Error: Client Secret is required!\n";
    exit(1);
}

// Read current .env content
$envContent = file_get_contents('.env');

// Remove existing Microsoft OAuth configuration if present
$envContent = preg_replace('/# Microsoft OAuth Configuration.*?\n/s', '', $envContent);
$envContent = preg_replace('/MICROSOFT_CLIENT_ID=.*?\n/', '', $envContent);
$envContent = preg_replace('/MICROSOFT_CLIENT_SECRET=.*?\n/', '', $envContent);
$envContent = preg_replace('/MICROSOFT_TENANT_ID=.*?\n/', '', $envContent);
$envContent = preg_replace('/MICROSOFT_REDIRECT_URI=.*?\n/', '', $envContent);

// Add new Microsoft OAuth configuration
$microsoftConfig = "\n# Microsoft OAuth Configuration\n";
$microsoftConfig .= "MICROSOFT_CLIENT_ID=f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7\n";
$microsoftConfig .= "MICROSOFT_CLIENT_SECRET=" . $clientSecret . "\n";
$microsoftConfig .= "MICROSOFT_TENANT_ID=4cf493e2-c44f-4a85-9650-f432e907ba34\n";
$microsoftConfig .= "MICROSOFT_REDIRECT_URI=http://localhost:8000/auth/microsoft/callback\n";

// Write updated content back to .env
file_put_contents('.env', $envContent . $microsoftConfig);

echo "\n✅ Microsoft OAuth configuration added successfully!\n";
echo "Microsoft login button is now available on your login page.\n\n";

echo "To test Microsoft OAuth:\n";
echo "1. Make sure your Laravel server is running: php artisan serve\n";
echo "2. Visit: http://127.0.0.1:8000/login\n";
echo "3. Click 'Sign in with Microsoft' button\n\n";

echo "🎉 Microsoft OAuth integration is complete!\n";
