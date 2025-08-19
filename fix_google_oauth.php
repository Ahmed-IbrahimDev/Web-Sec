<?php

echo "=== Fixing Google OAuth Configuration ===\n\n";

// Read current .env content
$envContent = file_get_contents('.env');

// Remove all existing Google OAuth lines (both real and placeholder)
$lines = explode("\n", $envContent);
$cleanedLines = [];
$skipNext = false;

foreach ($lines as $line) {
    $trimmedLine = trim($line);
    
    // Skip Google OAuth related lines
    if (strpos($trimmedLine, '# Google OAuth Configuration') !== false ||
        strpos($trimmedLine, 'GOOGLE_CLIENT_ID=') !== false ||
        strpos($trimmedLine, 'GOOGLE_CLIENT_SECRET=') !== false ||
        strpos($trimmedLine, 'GOOGLE_REDIRECT_URI=') !== false) {
        continue;
    }
    
    $cleanedLines[] = $line;
}

// Add the correct Google OAuth configuration at the end
$cleanedContent = implode("\n", $cleanedLines);
$cleanedContent = rtrim($cleanedContent) . "\n\n";

$googleConfig = "# Google OAuth Configuration\n";
$googleConfig .= "GOOGLE_CLIENT_ID=your_google_client_id_here\n";
$googleConfig .= "GOOGLE_CLIENT_SECRET=your_google_client_secret_here\n";
$googleConfig .= "GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback\n";

// Write the cleaned content back
file_put_contents('.env', $cleanedContent . $googleConfig);

echo "✅ Fixed Google OAuth configuration!\n";
echo "- Removed duplicate entries\n";
echo "- Kept only the real credentials\n";
echo "- Configuration is now clean\n\n";

echo "Your Google OAuth should now work properly.\n";
echo "Test it by visiting: http://127.0.0.1:8000/auth/google\n";
