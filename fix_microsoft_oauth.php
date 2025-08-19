<?php

echo "=== Microsoft OAuth Quick Fix ===\n\n";

echo "I can see your Microsoft OAuth is configured but missing the client secret.\n";
echo "Your current configuration:\n";
echo "- Client ID: f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7 ✅\n";
echo "- Tenant ID: 4cf493e2-c44f-4a85-9650-f432e907ba34 ✅\n";
echo "- Client Secret: [PLACEHOLDER] ❌\n\n";

echo "To fix Microsoft OAuth:\n";
echo "1. Go to Azure Portal: https://portal.azure.com/\n";
echo "2. Navigate to 'App registrations'\n";
echo "3. Find your app: f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7\n";
echo "4. Go to 'Certificates & secrets' -> 'Client secrets'\n";
echo "5. Click 'New client secret'\n";
echo "6. Copy the SECRET VALUE (not the ID)\n\n";

echo "Enter your Microsoft Client Secret (or press Enter to skip): ";
$clientSecret = trim(fgets(STDIN));

if (!empty($clientSecret)) {
    // Read current .env content
    $envContent = file_get_contents('.env');
    
    // Replace the placeholder client secret
    $envContent = str_replace(
        'MICROSOFT_CLIENT_SECRET=your-client-secret-from-azure',
        'MICROSOFT_CLIENT_SECRET=' . $clientSecret,
        $envContent
    );
    
    // Write back to .env
    file_put_contents('.env', $envContent);
    
    echo "\n✅ Microsoft OAuth client secret updated!\n";
    echo "Microsoft OAuth should now work properly.\n\n";
} else {
    echo "\nSkipped Microsoft OAuth configuration.\n";
    echo "Microsoft OAuth will continue to show authentication errors until you add the client secret.\n\n";
}

echo "Next: Let's test both OAuth providers...\n";
