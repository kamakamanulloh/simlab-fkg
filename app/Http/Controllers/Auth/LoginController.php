<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function loginAjax(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Throttle (anti brute force)
        $key = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'status'  => 'error',
                'message' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ], 429);
        }

        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            RateLimiter::clear($key);
          $user = Auth::user();

                if ($user && $user->role === 'Dosen') {
                    $redirect = route('dosen.dashboard');
                } 
                 elseif ($user->role === 'Mahasiswa') {
                    $redirect = route('mahasiswa.dashboard');
                } 
                else {
                    $redirect = route('dashboard');
                }
                return response()->json([
                    'status'   => 'ok',
                    'message'  => 'Login berhasil',
                    'redirect' => $redirect,
                ]);
        }

        RateLimiter::hit($key, 60);

        return response()->json([
            'status'  => 'error',
            'message' => 'Username atau password salah',
        ], 422);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function throttleKey(Request $request): string
    {
        return 'login:' . Str::lower($request->input('username')) . '|' . $request->ip();
    }
}
