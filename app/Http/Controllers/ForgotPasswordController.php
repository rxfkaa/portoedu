<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form "Lupa Password".
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim link/token reset password melalui email (SMTP Gmail).
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Respons yang sama untuk email terdaftar atau tidak mencegah orang
        // lain menebak email mana yang mempunyai akun.
        if (!$user) {
            return back()->with('status', 'Jika email tersebut terdaftar, link reset password akan dikirim. Silakan cek inbox dan folder spam.');
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['email' => $request->email, 'token' => Hash::make($token), 'created_at' => now()]
        );

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        try {
            Mail::to($user->email)->send(new PasswordResetMail($user, $resetUrl));
            return back()->with('status', 'Link reset password telah dikirim ke email kamu. Silakan cek inbox (termasuk folder spam).');
        } catch (\Throwable $e) {
            Log::error('Pengiriman email reset password gagal.', [
                'user_id' => $user->id,
                'exception' => $e,
            ]);

            return back()->withErrors(['email' => 'Link reset password belum dapat dikirim. Silakan coba lagi beberapa saat.']);
        }
    }

    /**
     * Tampilkan form reset password.
     */
    public function showResetForm(string $token, Request $request)
    {
        $email = $request->query('email');
        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Proses reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        $expiresAfter = config('auth.passwords.users.expire', 60);
        $isExpired = !$record || !$record->created_at
            || now()->greaterThan(\Carbon\Carbon::parse($record->created_at)->addMinutes($expiresAfter));

        if ($isExpired || !Hash::check($request->token, $record->token)) {
            if ($isExpired && $record) {
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            }
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kedaluwarsa.']);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $user->password = $request->password;
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan masuk.');
    }
}
