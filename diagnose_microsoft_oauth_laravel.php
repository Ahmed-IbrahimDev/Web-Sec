<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "=== Microsoft OAuth Diagnostic Tool ===\n\n";

// Check environment variables
echo "1. Checking Environment Variables:\n";
$clientId = env('MICROSOFT_CLIENT_ID');
$clientSecret = env('MICROSOFT_CLIENT_SECRET');
$tenantId = env('MICROSOFT_TENANT_ID');
$redirectUri = env('MICROSOFT_REDIRECT_URI');

echo "   MICROSOFT_CLIENT_ID: " . ($clientId ? "✅ " . substr($clientId, 0, 10) . "..." : "❌ Missing") . "\n";
echo "   MICROSOFT_CLIENT_SECRET: " . ($clientSecret && $clientSecret !== 'your-client-secret-from-azure' ? "✅ Set (length: " . strlen($clientSecret) . ")" : "❌ Missing/Placeholder") . "\n";
echo "   MICROSOFT_TENANT_ID: " . ($tenantId ? "✅ " . substr($tenantId, 0, 10) . "..." : "❌ Missing") . "\n";
echo "   MICROSOFT_REDIRECT_URI: " . ($redirectUri ? "✅ " . $redirectUri : "❌ Missing") . "\n\n";

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

echo "\n=== CURRENT CONFIGURATION STATUS ===\n";
echo "Based on your .env file, Microsoft OAuth should work if:\n";
echo "1. ✅ Client ID is set: f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7\n";
echo "2. ✅ Client Secret is set: 5f885cdd-2eff-426b-a9f3-c2b0484ce566\n";
echo "3. ✅ Tenant ID is set: 4cf493e2-c44f-4a85-9650-f432e907ba34\n";
echo "4. ✅ Redirect URI is set: http://localhost:8000/auth/microsoft/callback\n\n";

echo "=== POSSIBLE ISSUES ===\n";
echo "If Microsoft OAuth is still failing, check:\n";
echo "1. Azure App Registration redirect URI must EXACTLY match: http://localhost:8000/auth/microsoft/callback\n";
echo "2. Client secret might be expired or invalid\n";
echo "3. App permissions in Azure might not be configured\n";
echo "4. Tenant restrictions might be blocking the authentication\n\n";

echo "=== QUICK FIX SUGGESTIONS ===\n";
echo "1. Clear Laravel cache: php artisan config:clear\n";
echo "2. Test direct URL: http://localhost:8000/auth/microsoft\n";
echo "3. Check Azure app registration settings\n";
