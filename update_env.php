<?php

echo "🔧 تحديث ملف .env بـ Google OAuth Credentials\n";
echo "============================================\n\n";

// Get current .env content
$envContent = file_get_contents('.env');

// Show current Google settings
echo "الإعدادات الحالية:\n";
$lines = explode("\n", $envContent);
foreach ($lines as $line) {
    if (strpos($line, 'GOOGLE_') !== false) {
        echo $line . "\n";
    }
}

echo "\n📝 أدخل بيانات Google OAuth:\n";
echo "==========================\n";

echo "Client ID: ";
$clientId = trim(fgets(STDIN));

echo "Client Secret: ";
$clientSecret = trim(fgets(STDIN));

// Update .env file
$envContent = preg_replace('/GOOGLE_CLIENT_ID=.*/', 'GOOGLE_CLIENT_ID=' . $clientId, $envContent);
$envContent = preg_replace('/GOOGLE_CLIENT_SECRET=.*/', 'GOOGLE_CLIENT_SECRET=' . $clientSecret, $envContent);

file_put_contents('.env', $envContent);

echo "\n✅ تم تحديث ملف .env بنجاح!\n";
echo "الآن قم بتشغيل الأوامر التالية:\n\n";

echo "php artisan config:clear\n";
echo "php artisan cache:clear\n\n";

echo "🎯 ثم اذهب إلى: http://127.0.0.1:8000/login\n";
echo "واضغط على Sign in with Google\n"; 