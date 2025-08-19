<?php

// Read the current .env file
$envContent = file_get_contents('.env');

// Add Google OAuth configuration
$googleConfig = "\n# Google OAuth Configuration\n";
$googleConfig .= "GOOGLE_CLIENT_ID=your-google-client-id\n";
$googleConfig .= "GOOGLE_CLIENT_SECRET=your-google-client-secret\n";
$googleConfig .= "GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback\n";

// Append to the .env file
file_put_contents('.env', $envContent . $googleConfig);

echo "Google OAuth environment variables added to .env file!\n";
echo "Please update the GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET with your actual Google OAuth credentials.\n"; 