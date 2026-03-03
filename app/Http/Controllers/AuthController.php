<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Cache;
use App\Mail\NewUserRegistered;

class AuthController extends Controller
{
    /**
     * Redirect to Google OAuth consent page.
     */
    public function redirectToGoogle(Request $request)
    {
        $clientId = (string) config('services.google.client_id');
        $redirectUri = (string) config('services.google.redirect');

        if ($clientId === '' || $redirectUri === '') {
            return redirect()->route('login')->withErrors([
                'email' => 'Google sign-in is not configured yet. Please contact the administrator.',
            ]);
        }

        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'access_type' => 'online',
            'prompt' => 'select_account',
        ]);

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
    }

    /**
     * Handle Google OAuth callback.
     */
    public function handleGoogleCallback(Request $request)
    {
        $expectedState = (string) $request->session()->pull('google_oauth_state');
        $receivedState = (string) $request->input('state', '');

        if ($expectedState === '' || !hash_equals($expectedState, $receivedState)) {
            return redirect()->route('login')->withErrors([
                'email' => 'Invalid Google sign-in state. Please try again.',
            ]);
        }

        if ($request->filled('error')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google sign-in was cancelled or denied.',
            ]);
        }

        $code = (string) $request->input('code', '');
        if ($code === '') {
            return redirect()->route('login')->withErrors([
                'email' => 'Google sign-in failed. Missing authorization code.',
            ]);
        }

        $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $code,
            'client_id' => (string) config('services.google.client_id'),
            'client_secret' => (string) config('services.google.client_secret'),
            'redirect_uri' => (string) config('services.google.redirect'),
            'grant_type' => 'authorization_code',
        ]);

        if (!$tokenResponse->ok()) {
            Log::warning('Google token exchange failed.', ['body' => $tokenResponse->body()]);
            return redirect()->route('login')->withErrors([
                'email' => 'Unable to authenticate with Google right now. Please try again.',
            ]);
        }

        $accessToken = (string) $tokenResponse->json('access_token', '');
        if ($accessToken === '') {
            return redirect()->route('login')->withErrors([
                'email' => 'Google authentication did not return an access token.',
            ]);
        }

        $googleUserResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');
        if (!$googleUserResponse->ok()) {
            Log::warning('Google userinfo request failed.', ['body' => $googleUserResponse->body()]);
            return redirect()->route('login')->withErrors([
                'email' => 'Unable to fetch your Google profile. Please try again.',
            ]);
        }

        $googleUser = $googleUserResponse->json();
        $googleId = trim((string) ($googleUser['sub'] ?? ''));
        $email = strtolower(trim((string) ($googleUser['email'] ?? '')));
        $name = trim((string) ($googleUser['name'] ?? 'Google User'));
        $emailVerified = (bool) ($googleUser['email_verified'] ?? false);

        if ($googleId === '' || $email === '') {
            return redirect()->route('login')->withErrors([
                'email' => 'Google account is missing required profile details.',
            ]);
        }

        $user = User::where('google_id', $googleId)
            ->orWhere('email', $email)
            ->first();

        $isNewUser = false;

        if (!$user) {
            $user = User::create([
                'name' => $name !== '' ? $name : 'Google User',
                'email' => $email,
                'password' => Hash::make(Str::random(40)),
                'google_id' => $googleId,
                'status' => 'pending',
                'profile_completed' => false,
            ]);

            if ($emailVerified) {
                $user->email_verified_at = now();
                $user->save();
            }

            $this->notifyRegistrarsAboutNewUser($user);
            $this->sendWelcomeEmail($user);
            $isNewUser = true;
        } else {
            $shouldSave = false;

            if (!$user->google_id) {
                $user->google_id = $googleId;
                $shouldSave = true;
            }

            if ($emailVerified && !$user->email_verified_at) {
                $user->email_verified_at = now();
                $shouldSave = true;
            }

            if ($shouldSave) {
                $user->save();
            }
        }

        if ($user->status !== 'active') {
            if ($isNewUser) {
                return redirect()->route('login')->with('success', 'Google sign-up successful! Please wait for an email from the registrar to activate your account.');
            }

            return redirect()->route('login')->withErrors([
                'email' => 'Your account is pending approval. Please wait for the registrar to activate your account.',
            ])->onlyInput('email');
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->intended('dashboard');
    }

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login', ['action' => 'login']);
    }

    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.login', ['action' => 'register']);
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(Request $request)
    {
        $firstName = trim((string) $request->input('first_name', ''));
        $middleName = trim((string) $request->input('middle_name', ''));
        $lastName = trim((string) $request->input('last_name', ''));

        $fullName = trim(implode(' ', array_filter([$firstName, $middleName, $lastName])));
        $fullName = preg_replace('/\s+/', ' ', $fullName);

        $request->merge([
            'name' => $fullName,
            'email' => strtolower((string) $request->input('email')),
        ]);

        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class, 'regex:/@gmail\.com$/i'],
            'mobile_number' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string', 'in:Male,Female,Prefer not to say'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'agency' => ['required', 'in:DILG,LGU'],
            'region' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required_unless:agency,DILG', 'nullable', 'string', 'max:255'],
            'barangay' => ['required_unless:agency,DILG', 'nullable', 'string', 'max:255'],
        ], [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'agency.required' => 'Please select your agency.',
            'email.regex' => 'The email address must be a valid Gmail account (@gmail.com).',
            'email.unique' => 'This email address is already registered. Please use a different email or log in.',
        ]);

        // Explode full name to ensure consistent spacing/order before saving.
        $nameParts = preg_split('/\s+/', trim((string) $request->name), -1, PREG_SPLIT_NO_EMPTY);
        $firstNameFromFull = $nameParts ? array_shift($nameParts) : '';
        $lastNameFromFull = $nameParts ? array_pop($nameParts) : '';
        $middleNameFromFull = implode(' ', $nameParts);
        $normalizedName = trim(implode(' ', array_filter([$firstNameFromFull, $middleNameFromFull, $lastNameFromFull])));

        $user = User::create([
            'name' => $normalizedName,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'region' => $request->region,
            'province' => $request->province,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'status' => 'pending',
            'profile_completed' => true,
            'profile_completed_at' => now(),
        ]);

        $this->notifyRegistrarsAboutNewUser($user);
        $this->sendWelcomeEmail($user);

        // Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful! Please wait for an email from the registrar to activate your account.');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $maxAttempts = 5;
        $decaySeconds = 120; // 2 minutes
        $email = strtolower((string) $request->input('email'));
        $key = 'login:'.($email ?: 'guest').':'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            $mins = ceil($seconds / 60);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again for {$mins} minute(s).",
            ])->with('lockout_seconds', $seconds)->onlyInput('email');
        }

        // Validate the request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            if (Auth::user()->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your account is pending approval. Please wait for the registrar to activate your account.',
                ])->onlyInput('email');
            }

            // Auto-mark profile as completed for manual accounts with sufficient info
            $u = Auth::user();
            if (
                !$u->profile_completed &&
                empty($u->google_id) &&
                $u->name &&
                $u->email &&
                $u->region && $u->province && $u->city && $u->barangay
            ) {
                $u->profile_completed = true;
                $u->profile_completed_at = now();
                $u->save();
            }

            return redirect()->intended('dashboard');
        }

        // If authentication fails, hit the rate limiter and show remaining attempts or lockout
        RateLimiter::hit($key, $decaySeconds);
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            $mins = ceil($seconds / 60);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again for {$mins} minute(s).",
            ])->with('lockout_seconds', $seconds)->onlyInput('email');
        } else {
            $remaining = RateLimiter::remaining($key, $maxAttempts);
            return back()->withErrors([
                'email' => "Invalid credentials. Attempts remaining: {$remaining}.",
            ])->onlyInput('email');
        }
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower($request->input('email'));
        $otp = str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
        $expirySeconds = 120;
        $expiresAt = now()->addSeconds($expirySeconds);
        Cache::put("otp:{$email}", ['code' => $otp], $expiresAt);

        try {
            Mail::send('emails.password_reset_otp', ['code' => $otp, 'minutes' => 2], function ($message) use ($email) {
                $message->to($email)->subject('CAPDEV PRO Password Reset OTP');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send OTP email. Please try again later.'])->withInput();
        }

        return back()
            ->with('status', 'We have sent an OTP code to your email.')
            ->with('otp_email', $email)
            ->with('otp_expires_at', $expiresAt->timestamp);
    }

    public function verifyForgotOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'string', 'size:8'],
        ]);
        $email = strtolower($request->input('email'));
        $otp = $request->input('otp');
        $entry = Cache::get("otp:{$email}");
        if (!$entry) {
            return back()->withErrors(['otp' => 'OTP expired. Please request a new code.'])->with('otp_email', $email);
        }
        if (($entry['code'] ?? '') !== $otp) {
            return back()->withErrors(['otp' => 'Invalid OTP code.'])->with('otp_email', $email)->withInput();
        }

        Cache::forget("otp:{$email}");

        $request->session()->put('otp_verified_email', $email);
        return back()->with('status', 'OTP verified. Please update your password below.');
    }

    public function resendForgotOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $email = strtolower($request->input('email'));
        $otp = str_pad((string) random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
        $expirySeconds = 120;
        $expiresAt = now()->addSeconds($expirySeconds);
        Cache::put("otp:{$email}", ['code' => $otp], $expiresAt);
        try {
            Mail::send('emails.password_reset_otp', ['code' => $otp, 'minutes' => 2], function ($message) use ($email) {
                $message->to($email)->subject('CAPDEV PRO Password Reset OTP');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send OTP email. Please try again later.'])->with('otp_email', $email);
        }
        return back()
            ->with('status', 'We have sent a new OTP code to your email.')
            ->with('otp_email', $email)
            ->with('otp_expires_at', $expiresAt->timestamp);
    }
    public function updatePasswordAfterOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $email = strtolower($request->input('email'));
        $verifiedEmail = (string) $request->session()->get('otp_verified_email', '');
        if ($verifiedEmail === '' || !hash_equals($verifiedEmail, $email)) {
            return back()->withErrors(['email' => 'OTP not verified for this session. Please restart the process.'])
                         ->with('otp_email', $email);
        }
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Account not found for the provided email.'])
                         ->with('otp_verified_email', $email);
        }
        $user->password = Hash::make($request->input('password'));
        $user->save();
        $request->session()->forget('otp_verified_email');
        $request->session()->forget('otp_email');
        return redirect()->route('login')->with('success', 'Password updated successfully. Please log in with your new password.');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function notifyRegistrarsAboutNewUser(User $user): void
    {
        $registrars = User::where('role', 'registrar')->get();

        foreach ($registrars as $registrar) {
            Notification::create([
                'user_id' => $registrar->id,
                'title' => 'New User Registration',
                'message' => "New user {$user->name} has registered and is awaiting approval.",
                'type' => 'registration',
                'related_id' => $user->id,
                'link' => route('dashboard', ['tab' => 'user-management', 'search' => $user->name]),
            ]);
        }
    }

    private function sendWelcomeEmail(User $user): void
    {
        try {
            Mail::to($user->email)->send(new NewUserRegistered($user));
        } catch (\Exception $e) {
            // Log error silently so user flow isn't interrupted
            Log::error('Email sending failed: ' . $e->getMessage());
        }
    }
}
