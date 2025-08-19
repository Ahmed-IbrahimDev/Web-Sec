<?php

echo "=== إصلاح Microsoft OAuth Configuration ===\n\n";

// Read current .env content
$envContent = file_get_contents('.env');

// Remove all existing Microsoft OAuth lines (both real and placeholder)
$lines = explode("\n", $envContent);
$cleanedLines = [];

foreach ($lines as $line) {
    $trimmedLine = trim($line);
    
    // Skip Microsoft OAuth related lines
    if (strpos($trimmedLine, '# Microsoft OAuth Configuration') !== false ||
        strpos($trimmedLine, 'MICROSOFT_CLIENT_ID=') !== false ||
        strpos($trimmedLine, 'MICROSOFT_CLIENT_SECRET=') !== false ||
        strpos($trimmedLine, 'MICROSOFT_REDIRECT_URI=') !== false ||
        strpos($trimmedLine, 'MICROSOFT_TENANT_ID=') !== false) {
        continue;
    }
    
    $cleanedLines[] = $line;
}

// Add the correct Microsoft OAuth configuration at the end
$cleanedContent = implode("\n", $cleanedLines);
$cleanedContent = rtrim($cleanedContent) . "\n\n";

// Based on the memory, your Microsoft OAuth configuration should be:
$microsoftConfig = "# Microsoft OAuth Configuration\n";
$microsoftConfig .= "MICROSOFT_CLIENT_ID=f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7\n";
$microsoftConfig .= "MICROSOFT_CLIENT_SECRET=YOUR_CLIENT_SECRET_HERE\n";
$microsoftConfig .= "MICROSOFT_REDIRECT_URI=http://localhost:8000/auth/microsoft/callback\n";
$microsoftConfig .= "MICROSOFT_TENANT_ID=4cf493e2-c44f-4a85-9650-f432e907ba34\n";

// Write the cleaned content back
file_put_contents('.env', $cleanedContent . $microsoftConfig);

echo "✅ تم إصلاح Microsoft OAuth configuration!\n";
echo "- تم إضافة Microsoft OAuth environment variables\n";
echo "- Application ID: f8cefd5c-53d0-4ae2-9132-3ccee7d44ee7\n";
echo "- Tenant ID: 4cf493e2-c44f-4a85-9650-f432e907ba34\n";
echo "- Redirect URI: http://localhost:8000/auth/microsoft/callback\n\n";

echo "⚠️ مطلوب منك:\n";
echo "1. إضافة MICROSOFT_CLIENT_SECRET في Azure Portal\n";
echo "2. تحديث الـ .env file بالـ client secret الصحيح\n\n";

echo "بعد إضافة الـ client secret، Microsoft OAuth سيعمل بشكل صحيح.\n";
echo "اختبر على: http://localhost:8000/login\n";
