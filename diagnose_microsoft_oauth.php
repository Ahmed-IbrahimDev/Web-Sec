<?php

echo "=== Microsoft OAuth Diagnostic Tool ===\n\n";

// Check environment variables
echo "1. Checking Environment Variables:\n";
$clientId = env('MICROSOFT_CLIENT_ID');
$clientSecret = env('MICROSOFT_CLIENT_SECRET');
$tenantId = env('MICROSOFT_TENANT_ID');
$redirectUri = env('MICROSOFT_REDIRECT_URI');

echo "   MICROSOFT_CLIENT_ID: " . ($clientId ? "✅ Set" : "❌ Missing") . "\n";
echo "   MICROSOFT_CLIENT_SECRET: " . ($clientSecret && $clientSecret !== 'your-client-secret-from-azure' ? "✅ Set" : "❌ Missing/Placeholder") . "\n";
echo "   MICROSOFT_TENANT_ID: " . ($tenantId ? "✅ Set" : "❌ Missing") . "\n";
echo "   MICROSOFT_REDIRECT_URI: " . ($redirectUri ? "✅ Set" : "❌ Missing") . "\n\n";

// Check if Microsoft provider is installed
echo "2. Checking Microsoft Socialite Provider:\n";
if (class_exists('SocialiteProviders\\Microsoft\\Provider')) {
    echo "   ✅ Microsoft Socialite Provider is installed\n";
} else {
    echo "   ❌ Microsoft Socialite Provider is NOT installed\n";
    echo "   Run: composer require socialiteproviders/microsoft\n";
}

// Check services configuration
echo "\n3. Checking Services Configuration:\n";
$services = config('services.microsoft');
if ($services) {
    echo "   ✅ Microsoft service configuration exists\n";
    echo "   Client ID: " . ($services['client_id'] ?? 'Missing') . "\n";
    echo "   Redirect: " . ($services['redirect'] ?? 'Missing') . "\n";
    echo "   Tenant: " . ($services['tenant'] ?? 'Missing') . "\n";
} else {
    echo "   ❌ Microsoft service configuration is missing\n";
}

// Test Microsoft OAuth URL generation
echo "\n4. Testing Microsoft OAuth URL Generation:\n";
try {
    $driver = Socialite::driver('microsoft');
    echo "   ✅ Microsoft OAuth driver loaded successfully\n";
    
    // Try to generate the redirect URL
    $redirectUrl = $driver->redirect()->getTargetUrl();
    echo "   ✅ Redirect URL generated: " . substr($redirectUrl, 0, 100) . "...\n";
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== DIAGNOSTIC COMPLETE ===\n";
echo "If all checks pass but Microsoft OAuth still fails, the issue might be:\n";
echo "1. Invalid client secret from Azure\n";
echo "2. Incorrect redirect URI in Azure app registration\n";
echo "3. App permissions not configured in Azure\n";
echo "4. Tenant restrictions\n\n";

echo "Next steps:\n";
echo "1. Verify your Azure app registration settings\n";
echo "2. Check that redirect URI matches exactly: http://localhost:8000/auth/microsoft/callback\n";
echo "3. Ensure the client secret is valid and not expired\n";
