<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Handle user login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        // Sanitize inputs
        $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
        $password = $request->password;

        // Attempt login
        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Handle user registration
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Sanitize inputs
        $name = filter_var($request->name, FILTER_SANITIZE_STRING);
        $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
        $password = $request->password;

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // All new users get 'user' role (no admin privileges)
        $userRole = Role::where('name', 'user')->first();
        if ($userRole) {
            $user->roles()->attach($userRole);
        }

        // Log the user in
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Handle user logout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(uniqid()), // Generate random password
                    'google_id' => $googleUser->id,
                ]);

                // Assign default user role
                $userRole = Role::where('name', 'user')->first();
                if ($userRole) {
                    $user->roles()->attach($userRole);
                }
            } else {
                // Update existing user's Google ID if not set
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            }

            // Log the user in
            Auth::login($user);

            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google authentication failed. Please try again.',
            ]);
        }
    }

    /**
     * Redirect the user to the LinkedIn authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToLinkedIn()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Obtain the user information from LinkedIn.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleLinkedInCallback()
    {
        try {
            $linkedinUser = Socialite::driver('linkedin')->user();
            
            // Check if user already exists
            $user = User::where('email', $linkedinUser->email)->first();
            
            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $linkedinUser->name,
                    'email' => $linkedinUser->email,
                    'password' => Hash::make(uniqid()), // Generate random password
                    'linkedin_id' => $linkedinUser->id,
                ]);

                // Assign default user role
                $userRole = Role::where('name', 'user')->first();
                if ($userRole) {
                    $user->roles()->attach($userRole);
                }
            } else {
                // Update existing user's LinkedIn ID if not set
                if (!$user->linkedin_id) {
                    $user->update(['linkedin_id' => $linkedinUser->id]);
                }
            }

            // Log the user in
            Auth::login($user);

            return redirect()->route('dashboard');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'LinkedIn authentication failed. Please try again.',
            ]);
        }
    }
}