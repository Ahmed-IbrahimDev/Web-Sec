# Google OAuth Setup Guide

## Option 1: Fix Existing OAuth Client (Recommended)

Your current OAuth Client ID: `219523588810-osllf5j875uq2b6ag8tudj2n736filnu.apps.googleusercontent.com`

### Steps:
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Navigate to **APIs & Services** → **Credentials**
3. Find your OAuth 2.0 Client ID and click **Edit**
4. In **Authorized redirect URIs**, add:
   ```
   http://localhost:8000/auth/google/callback
   ```
5. Click **Save**

## Option 2: Create New OAuth Client

If you can't access the existing client, create a new one:

### Steps:
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing project
3. Enable Google+ API:
   - Go to **APIs & Services** → **Library**
   - Search for "Google+ API" and enable it
4. Create OAuth 2.0 Client:
   - Go to **APIs & Services** → **Credentials**
   - Click **+ CREATE CREDENTIALS** → **OAuth client ID**
   - Choose **Web application**
   - Name: `WebSec Laravel App`
   - **Authorized redirect URIs**: `http://localhost:8000/auth/google/callback`
   - Click **Create**
5. Copy the Client ID and Client Secret
6. Update your `.env` file with the new credentials

## Current .env Configuration

Your `.env` file should have:
```
GOOGLE_CLIENT_ID=your_new_client_id_here
GOOGLE_CLIENT_SECRET=your_new_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## Testing

After updating Google Cloud Console:
1. Visit: http://localhost:8000/login
2. Click "Sign in with Google"
3. Should redirect to Google authentication without errors

## Troubleshooting

- Make sure the redirect URI exactly matches: `http://localhost:8000/auth/google/callback`
- Ensure Google+ API is enabled in your Google Cloud project
- Clear browser cache if needed
- Check that your Laravel app is running on port 8000
