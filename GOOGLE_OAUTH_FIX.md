# Fix Google OAuth "invalid_client" Error

## The Problem
You're getting "The OAuth client was not found" error because your `.env` file still has placeholder values instead of real Google OAuth credentials.

## Step-by-Step Solution

### 1. Create Google OAuth Credentials

1. **Go to Google Cloud Console**: https://console.cloud.google.com/
2. **Create/Select Project**: Create a new project or select existing one
3. **Enable Google+ API**:
   - Go to "APIs & Services" > "Library"
   - Search for "Google+ API" and click "Enable"
4. **Create OAuth 2.0 Credentials**:
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "OAuth 2.0 Client IDs"
   - Choose "Web application"
   - Set these values:
     - **Name**: WebSec OAuth Client
     - **Authorized redirect URIs**: `http://127.0.0.1:8000/auth/google/callback`
     - **Authorized JavaScript origins**: `http://127.0.0.1:8000`
5. **Copy Credentials**: You'll get a Client ID and Client Secret

### 2. Update Your .env File

Replace the placeholder values in your `.env` file:

```env
# Replace these placeholder values:
GOOGLE_CLIENT_ID=your-actual-google-client-id
GOOGLE_CLIENT_SECRET=your-actual-google-client-secret

# With your actual credentials (example):
GOOGLE_CLIENT_ID=your-actual-google-client-id
GOOGLE_CLIENT_SECRET=your-actual-google-client-secret
```

### 3. Clear Laravel Cache

Run these commands after updating the .env file:

```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Test the Fix

1. Visit: http://127.0.0.1:8000/login
2. Click "Sign in with Google"
3. You should now see Google's consent screen instead of the error

## Common Issues & Solutions

### Issue: "redirect_uri_mismatch"
- **Solution**: Make sure the redirect URI in Google Console exactly matches: `http://127.0.0.1:8000/auth/google/callback`

### Issue: "invalid_client"
- **Solution**: Double-check that you copied the Client ID and Secret correctly from Google Console

### Issue: "access_denied"
- **Solution**: Make sure you enabled the Google+ API in your Google Cloud Console

## Security Notes

- Never commit your actual Google credentials to version control
- Use environment variables for sensitive configuration
- Consider using HTTPS in production
- Regularly rotate your OAuth credentials 