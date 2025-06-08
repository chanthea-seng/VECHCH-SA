<?php

namespace App\Http\Controllers\Auth;

use App\Models\DoctorProfile;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordCode;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private const LOGIN_ATTEMPTS_PER_MINUTE = 5;
    private const REGISTER_ATTEMPTS_PER_MINUTE = 3;
    private const TOKEN_EXPIRATION_DAYS = 15;

    private function generateResetCode(): string
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $code = '';
        for ($i = 0; $i < 4; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }

    public function __construct()
    {
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(self::LOGIN_ATTEMPTS_PER_MINUTE)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'result' => false,
                        'message' => 'Too many login attempts. Please try again later.',
                    ], 429);
                });
        });

        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(self::REGISTER_ATTEMPTS_PER_MINUTE)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'result' => false,
                        'message' => 'Too many registration attempts. Please try again later.',
                    ], 429);
                });
        });

        RateLimiter::for('forgot-password', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'result' => false,
                        'message' => 'Too many reset attempts. Please try again later.',
                    ], 429);
                });
        });

        $this->middleware(function ($request, $next) {
            $user = $request->user('sanctum');
            if ($user && $user->currentAccessToken()) {
                $tokenCreatedAt = $user->currentAccessToken()->created_at;
                if ($tokenCreatedAt->diffInDays(now()) > self::TOKEN_EXPIRATION_DAYS) {
                    $user->currentAccessToken()->delete();
                    return response()->json([
                        'result' => false,
                        'message' => 'Token has expired. Please login again.',
                    ], 401);
                }
            }
            return $next($request);
        })->only(['logout', 'getMe']);
    }

    public function register(Request $request)
    {
        try {
            $request->validate(
                [
                    'fullname' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:users,email',
                    'password' => 'required|string|min:8|confirmed',
                    'specialist_id' => 'required_if:role,doctor|exists:specialists,id',
                    'department_id' => 'required_if:role,doctor|exists:departments,id',
                    'center_id' => 'required_if:role,doctor|exists:centers,id',
                ],
                [
                    'specialist_id.required_if' => 'Specialist ID is required for doctors.',
                    'department_id.required_if' => 'Department ID is required for doctors.',
                    'center_id.required_if' => 'Center ID is required for doctors.',
                ]
            );

            $roleId = 3;
            if ($authUser = request()->user()) {
                if ($authUser->role_id === 1) {
                    $roleId = 2;
                }
            }

            $user = User::create([
                'fullname' => trim($request->fullname),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'avatar' => 'user/no_avatar.jpg',
                'role_id' => $roleId,
            ]);

            if ($roleId === 2) {
                DoctorProfile::create([
                    'user_id' => $user->id,
                    'biography' => $request->biography ?? '',
                    'spoken_languages' => json_encode($request->spoken_languages ?? []),
                    'is_author' => $request->is_author ?? 0,
                    'specialist_id' => $request->specialist_id,
                    'department_id' => $request->department_id,
                    'center_id' => $request->center_id,
                ]);
            }

            $token = $user->createToken('auth-token')->plainTextToken;
            $user->load([
                'role',
                'doctorProfile' => fn($query) =>
                    $query->with(['center', 'specialist', 'department'])
            ]);

            return response()->json([
                'result' => true,
                'message' => 'Registration successful!',
                // 'token' => $token,
                'user' => new UserResource($user),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function registerDoc(Request $request)
    {
        try {
            $request->validate([
                'fullname' => 'required|string|max:255',
                'local_fullname' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = Auth::user();
            if (!$user || $user->role_id !== 1) {
                return response()->json([
                    'result' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $roleId = 2;
            $user = User::create([
                'local_fullname' => trim($request->local_fullname),
                'fullname' => trim($request->fullname),
                'email' => strtolower($request->email),
                'password' => Hash::make($request->password),
                'avatar' => 'user/no_avatar.jpg',
                'role_id' => $roleId,
            ]);

            DoctorProfile::create([
                'user_id' => $user->id,
                'biography' => $request->biography ?? '',
                'spoken_languages' => json_encode($request->spoken_languages ?? []),
                'is_author' => $request->is_author ?? 0,
                'specialist_id' => $request->specialist_id ?? null,
                'department_id' => $request->department_id ?? null,
                'center_id' => $request->center_id ?? null,
            ]);

            $user->load([
                'role',
                'doctorProfile' => fn($query) => $query->with(['center', 'specialist', 'department'])
            ]);

            return response()->json([
                'result' => true,
                'message' => 'Registration successful!',
                'user' => new UserResource($user),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $key = 'login:' . $request->ip();
            $maxAttempts = 5;

            if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
                $seconds = RateLimiter::availableIn($key);
                return response()->json([
                    'result' => false,
                    'message' => "Too many login attempts. Please try again in {$seconds} seconds.",
                ], 429);
            }

            $user = User::where('email', strtolower($request->email))->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                RateLimiter::hit($key);
                $remaining = RateLimiter::remaining($key, $maxAttempts);
                throw ValidationException::withMessages([
                    'credentials' => ["Invalid credentials. {$remaining} attempts remaining."],
                ]);
            }

            if ($user->tokens()->count() > 0) {
                $user->tokens()->delete();
            }

            RateLimiter::clear($key);
            $token = $user->createToken('auth-token', ['*'], now()->addDays(15))
                ->plainTextToken;

            $user->load([
                'role',
                'doctorProfile' => fn($query) =>
                    $query->with(['center', 'specialist', 'department'])
            ]);

            return response()->json([
                'result' => true,
                'message' => 'Welcome back, ' . $user->fullname . '!',
                'token' => $token,
                'expires_at' => now()->addDays(15)->toDateTimeString(),
                'user' => new UserResource($user),
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Login failed',
                'errors' => $e->errors(),
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'An error occurred during login: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user('sanctum')->currentAccessToken()->delete();

            return response()->json([
                'result' => true,
                'message' => 'Successfully logged out',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Logout failed',
            ], 500);
        }
    }

    public function getMe(Request $request)
    {
        try {
            $user = $request->user();
            $user->load([
                'role',
                'doctorProfile' => fn($query) =>
                    $query->with(['center', 'specialist', 'department'])
            ]);

            return response()->json([
                'result' => true,
                'message' => 'User data retrieved successfully',
                'user' => new UserResource($user),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to retrieve user data: ' . $e->getMessage(),
            ], 401);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $key = 'forgot-password:' . $request->ip();
            if (RateLimiter::tooManyAttempts($key, 5)) {
                $seconds = RateLimiter::availableIn($key);
                return response()->json([
                    'result' => false,
                    'message' => "Too many reset attempts. Please try again in {$seconds} seconds.",
                ], 429);
            }

            $request->validate([
                'email' => 'required|email|max:255|exists:users,email',
            ]);

            $user = User::where('email', strtolower($request->email))->first();
            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => ['No account found with this email.'],
                ]);
            }

            $code = $this->generateResetCode();

            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $code, 'created_at' => now()]
            );

            Mail::to($request->email)->send(new ResetPasswordCode($code));

            RateLimiter::hit($key);

            return response()->json([
                'result' => true,
                'message' => 'A 4-character code has been sent to your email.',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Failed to send reset code: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function verifyResetCode(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|max:255|exists:users,email',
                'otp' => 'required|string|size:4',
            ]);

            $reset = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->otp)
                ->first();

            if (!$reset || now()->diffInMinutes($reset->created_at) > 5) {
                throw ValidationException::withMessages([
                    'otp' => ['Invalid or expired code.'],
                ]);
            }

            return response()->json([
                'result' => true,
                'message' => 'Code verified successfully.',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Verification failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|max:255|exists:users,email',
                'otp' => 'required|string|size:4',
                'newpass' => 'required|string|confirmed',
            ]);

            $reset = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->otp)
                ->first();

            if (!$reset || now()->diffInMinutes($reset->created_at) > 5) {
                throw ValidationException::withMessages([
                    'otp' => ['Invalid or expired code.'],
                ]);
            }

            $user = User::where('email', $request->email)->first();
            $user->update(['password' => Hash::make($request->newpass)]);

            DB::table('password_resets')->where('email', $request->email)->delete();

            return response()->json([
                'result' => true,
                'message' => 'Password reset successfully.',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => 'Reset failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
