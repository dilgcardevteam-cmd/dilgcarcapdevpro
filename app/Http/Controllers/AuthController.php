<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckInactivityTimeout;
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
            'field_of_work' => ['required', 'string', 'max:255'],
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

        $isDILG = $request->agency === 'DILG';
        $role = 'participant'; // Default role
        if ($isDILG) {
            if ($request->region === 'DILG Central Office') {
                $role = 'central_office_participants';
            } elseif ($request->region === 'DILG Regional Office') {
                $role = 'regional_office_participants';
            } elseif ($request->region === 'DILG Provincial Office') {
                $role = 'provincial_office_participants';
            }
        }

        $user = User::create([
            'name' => $normalizedName,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'role' => $role,
            'field_of_work' => $request->field_of_work,
            'region' => $request->region,
            'province' => $request->province,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'status' => 'pending',
            'profile_completed' => true,
            'profile_completed_at' => now(),
        ]);

        User::notifyRegistrarsAboutNewUser($user);
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

            $u = Auth::user();
            if ($u && $u->status === 'active' && !$u->profile_completed) {
                $role = $u->role ?? '';
                $isCentral = in_array($role, ['central_office_admin','central_office_training_manager','central_office_coach','central_office_participants'], true);
                $isRegional = in_array($role, ['regional_office_admin','regional_office_training_manager','regional_office_coach','regional_office_participants'], true);
                $isProvincial = in_array($role, ['provincial_office_admin','provincial_office_training_manager','provincial_office_coach','provincial_office_participants'], true);
                if ($isCentral || $isRegional || $isProvincial) {
                    if ($isCentral) {
                        $u->region = $u->region ?: 'DILG Central Office';
                        $u->province = $u->province ?: 'Bureaus';
                        $u->city = $u->city ?: 'Bureau of Local Government Development (BLGD)';
                        $u->barangay = $u->barangay ?: null;
                    } elseif ($isRegional) {
                        $u->region = $u->region ?: 'DILG Regional Office';
                        $u->province = $u->province ?: 'DILG Cordillera Administrative Region (CAR) Office';
                        $u->city = $u->city ?: null;
                        $u->barangay = $u->barangay ?: null;
                    } elseif ($isProvincial) {
                        $u->region = $u->region ?: 'DILG Provincial Office';
                        $u->province = $u->province ?: 'DILG Cordillera Administrative Region (CAR) Office';
                        $u->city = $u->city ?: null;
                        $u->barangay = $u->barangay ?: null;
                    }
                    $u->profile_completed = true;
                    $u->profile_completed_at = now();
                    $u->save();
                } elseif (
                    $u->name && $u->email &&
                    $u->region && $u->province && $u->city && $u->barangay
                ) {
                    $u->profile_completed = true;
                    $u->profile_completed_at = now();
                    $u->save();
                }
            }

            if (!$u->profile_completed) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'email' => 'Please complete your profile registration first.',
                ])->onlyInput('email');
            }

            if ($u->status === 'pending') {
                return redirect()->route('pending.approval');
            }

            if ($u->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your account cannot access the system right now. Please contact the administrator.',
                ])->onlyInput('email');
            }

            return redirect()->intended(route('dashboard'));
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

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Logged out successfully.',
                'redirect' => route('login'),
            ]);
        }

        return redirect('/');
    }

    public function keepAlive(Request $request)
    {
        $now = now()->timestamp;
        $timeoutSeconds = CheckInactivityTimeout::resolveTimeoutSeconds((string) (Auth::user()->role ?? ''));

        $request->session()->put('last_activity_at', $now);
        $request->session()->put('last_activity_keep_alive', $now);
        $request->session()->save();

        return response()->json([
            'ok' => true,
            'timeout_seconds' => $timeoutSeconds,
            'expires_at' => $now + $timeoutSeconds,
        ]);
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
