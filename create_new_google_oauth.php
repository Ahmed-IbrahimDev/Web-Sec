<?php

echo "=== Creating New Google OAuth Configuration ===\n\n";

echo "CURRENT PROBLEM:\n";
echo "- Your existing Google OAuth client doesn't have the correct redirect URI\n";
echo "- Client ID: 219523588810-osllf5j875uq2b6ag8tudj2n736filnu.apps.googleusercontent.com\n";
echo "- This requires manual Google Cloud Console access to fix\n\n";

echo "SOLUTION: Create a new Google OAuth application\n\n";

echo "STEP 1: Go to Google Cloud Console\n";
echo "URL: https://console.cloud.google.com/\n\n";

echo "STEP 2: Create or Select Project\n";
echo "- If you don't have a project, create one\n";
echo "- Name it something like 'WebSec Laravel App'\n\n";

echo "STEP 3: Enable Google+ API\n";
echo "- Go to 'APIs & Services' → 'Library'\n";
echo "- Search for 'Google+ API'\n";
echo "- Click 'Enable'\n\n";

echo "STEP 4: Create OAuth 2.0 Client ID\n";
echo "- Go to 'APIs & Services' → 'Credentials'\n";
echo "- Click '+ CREATE CREDENTIALS' → 'OAuth client ID'\n";
echo "- Application type: 'Web application'\n";
echo "- Name: 'WebSec Laravel OAuth'\n";
echo "- Authorized redirect URIs: http://localhost:8000/auth/google/callback\n";
echo "- Click 'Create'\n\n";

echo "STEP 5: Copy the new credentials\n";
echo "- Copy the Client ID\n";
echo "- Copy the Client Secret\n\n";

echo "STEP 6: Update your .env file\n";
echo "Replace the current Google OAuth lines with your new credentials:\n\n";
echo "GOOGLE_CLIENT_ID=your_new_client_id_here\n";
echo "GOOGLE_CLIENT_SECRET=your_new_client_secret_here\n";
echo "GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback\n\n";

echo "ALTERNATIVE: If you have access to the existing OAuth client\n";
echo "- Go to: https://console.cloud.google.com/apis/credentials\n";
echo "- Find client: 219523588810-osllf5j875uq2b6ag8tudj2n736filnu.apps.googleusercontent.com\n";
echo "- Click edit (pencil icon)\n";
echo "- Add redirect URI: http://localhost:8000/auth/google/callback\n";
echo "- Save\n\n";

echo "After completing either option, your Google OAuth will work!\n";
echo "Test at: http://localhost:8000/login\n";
