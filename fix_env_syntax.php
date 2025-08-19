<?php

echo "=== Fixing .env File Syntax Error ===\n\n";

// Read current .env content
$envContent = file_get_contents('.env');

echo "Issue found: Invalid .env syntax causing HTTP 500 error\n";
echo "Problem line: MICROSOFT_CLIENT_SECRET=your-client-secret-from-azure  ← NEEDS REAL SECRET\n\n";

// Fix the problematic line by removing the inline comment
$envContent = str_replace(
    'MICROSOFT_CLIENT_SECRET=your-client-secret-from-azure  ← NEEDS REAL SECRET',
    'MICROSOFT_CLIENT_SECRET=your-client-secret-from-azure',
    $envContent
);

// Also remove any duplicate commented line
$envContent = str_replace(
    '# MICROSOFT_CLIENT_SECRET=your-client-secret-from-azure',
    '',
    $envContent
);

// Clean up any extra empty lines
$envContent = preg_replace('/\n\s*\n\s*\n/', "\n\n", $envContent);

// Write the fixed content back
file_put_contents('.env', $envContent);

echo "✅ Fixed .env file syntax error!\n";
echo "✅ Removed invalid inline comment\n";
echo "✅ Cleaned up duplicate entries\n\n";

echo "The HTTP 500 error should now be resolved.\n";
echo "Your Laravel application should be accessible again.\n\n";

echo "Note: Microsoft OAuth still needs a real client secret to work properly.\n";
