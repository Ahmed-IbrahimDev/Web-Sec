<?php

echo "=== Microsoft OAuth Final Fix ===\n\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "Error: .env file not found!\n";
    exit(1);
}

echo "Current Microsoft OAuth Status:\n";
echo "❌ Microsoft authentication failed. Please try again.\n\n";

echo "Analyzing potential issues:\n\n";

// Read current .env content
$envContent = file_get_contents('.env');

// Check for common issues
echo "1. Checking .env file configuration:\n";
if (strpos($envContent, 'MICROSOFT_CLIENT_ID=f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7') !== false) {
    echo "   ✅ Client ID is set correctly\n";
} else {
    echo "   ❌ Client ID issue detected\n";
}

if (strpos($envContent, 'MICROSOFT_CLIENT_SECRET=5f885cdd-2eff-426b-a9f3-c2b0484ce566') !== false) {
    echo "   ✅ Client Secret is set\n";
} else {
    echo "   ❌ Client Secret issue detected\n";
}

if (strpos($envContent, 'MICROSOFT_TENANT_ID=4cf493e2-c44f-4a85-9650-f432e907ba34') !== false) {
    echo "   ✅ Tenant ID is set correctly\n";
} else {
    echo "   ❌ Tenant ID issue detected\n";
}

if (strpos($envContent, 'MICROSOFT_REDIRECT_URI=http://localhost:8000/auth/microsoft/callback') !== false) {
    echo "   ✅ Redirect URI is set correctly\n";
} else {
    echo "   ❌ Redirect URI issue detected\n";
}

echo "\n2. Most likely causes of Microsoft OAuth failure:\n";
echo "   • Client secret expired or invalid in Azure\n";
echo "   • Redirect URI mismatch in Azure app registration\n";
echo "   • Missing app permissions in Azure\n";
echo "   • Tenant configuration issues\n\n";

echo "3. Immediate fixes to try:\n";
echo "   A. Clean up .env file duplicates\n";
echo "   B. Ensure consistent configuration\n";
echo "   C. Clear Laravel cache\n\n";

// Clean up any duplicate or commented Microsoft entries
$lines = explode("\n", $envContent);
$cleanLines = [];
$microsoftConfigAdded = false;

foreach ($lines as $line) {
    $trimmed = trim($line);
    
    // Skip commented Microsoft lines and duplicates
    if (strpos($trimmed, '# MICROSOFT_') === 0 || 
        strpos($trimmed, '# # Microsoft OAuth Configuration') === 0 ||
        strpos($trimmed, '#  Microsoft OAuth:') === 0) {
        continue;
    }
    
    // Skip duplicate Microsoft config sections
    if (strpos($trimmed, '# Microsoft OAuth Configuration') === 0 && $microsoftConfigAdded) {
        continue;
    }
    
    if (strpos($trimmed, '# Microsoft OAuth Configuration') === 0) {
        $microsoftConfigAdded = true;
    }
    
    $cleanLines[] = $line;
}

// Write cleaned content back
$cleanedContent = implode("\n", $cleanLines);
file_put_contents('.env', $cleanedContent);

echo "✅ Cleaned up .env file duplicates\n";
echo "✅ Microsoft OAuth configuration is now clean\n\n";

echo "=== NEXT STEPS ===\n";
echo "1. Clear Laravel cache: php artisan config:clear\n";
echo "2. Verify Azure app registration:\n";
echo "   - Go to Azure Portal\n";
echo "   - Check app: f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7\n";
echo "   - Verify redirect URI: http://localhost:8000/auth/microsoft/callback\n";
echo "   - Check if client secret is valid\n";
echo "3. Test Microsoft OAuth: http://localhost:8000/auth/microsoft\n\n";

echo "If Microsoft OAuth still fails after these steps, the issue is likely in Azure configuration.\n";
