# Google OAuth Setup Guide

## Step 1: Create Google OAuth Credentials

1. Go to the [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the Google+ API:
   - Go to "APIs & Services" > "Library"
   - Search for "Google+ API" and enable it
4. Create OAuth 2.0 credentials:
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "OAuth 2.0 Client IDs"
   - Choose "Web application"
   - Set the following:
     - **Authorized redirect URIs**: `http://127.0.0.1:8000/auth/google/callback`
     - **Authorized JavaScript origins**: `http://127.0.0.1:8000`

## Step 2: Update Environment Variables

1. Open the `.env` file in your project root
2. Replace the placeholder values with your actual Google OAuth credentials:
   ```
   GOOGLE_CLIENT_ID=your-actual-client-id
   GOOGLE_CLIENT_SECRET=your-actual-client-secret
   GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback
   ```

## Step 3: Test the Implementation

1. Start your Laravel development server:
   ```bash
   php artisan serve
   ```

2. Visit `http://127.0.0.1:8000/login`

3. Click the "Sign in with Google" button

4. You should be redirected to Google's OAuth consent screen

5. After authorization, you'll be redirected back to your application and logged in

## Troubleshooting

- Make sure the redirect URI in your Google OAuth credentials exactly matches: `http://127.0.0.1:8000/auth/google/callback`
- Ensure the Google+ API is enabled in your Google Cloud Console
- Check that your `.env` file has the correct credentials
- Clear Laravel's config cache: `php artisan config:clear`

## Security Notes

- Never commit your actual Google OAuth credentials to version control
- Use environment variables for sensitive configuration
- Consider using HTTPS in production
- Regularly rotate your OAuth credentials 