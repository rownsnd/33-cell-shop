<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ResetPassword;
use Illuminate\Support\Facades\Auth;

class ForgotController extends Controller
{
    public function index()
    {
        $title = 'Lupa Kata Sandi';
        return view('authentication.forgot-password', compact('title'));
    }

    public function forgot_password(Request $request)
    {
        // Validasi input email
        $request->validate([
            'email' => 'required|email',
        ]);
    
        // Kirim link reset password menggunakan Laravel Password Broker
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        // Berikan respon berdasarkan status pengiriman link
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }
    
        // Jika gagal, lemparkan error
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
    
    public function reset_password($token)
    {
        $title = 'Reset Kata Sandi';
        return view('authentication.reset-password', ['token' => $token], compact('title'));
    }

    public function reset_password_store(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    
        // Proses reset password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
    
                $user->save();
    
                // Trigger event bawaan Laravel
                event(new PasswordReset($user));
            }
        );
    
        // Jika reset berhasil
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __('Your password has been reset!'));
        }
    
        // Jika gagal, tampilkan error
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
    
}

