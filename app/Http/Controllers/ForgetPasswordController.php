<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('sessions.forgetPassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email|exists_not_soft_deleted',
        ], [
            'email.required' => 'Email harus diisi',
            'email.exists_not_soft_deleted' => 'Email telah dihapus oleh sistem. Silahkan hubungi admin untuk mengaktifkan akun anda',
            'email.exists' => 'Email tidak ditemukan',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect('/sessions')->with('success', 'Silahkan cek email anda untuk reset password');
    }

    public function showResetPasswordForm($token)
    {
        return view('sessions.resetPassword', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email|exists_not_soft_deleted',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withErrors(['email' => 'Email atau token tidak valid']);
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

        return redirect('/sessions')->with('success', 'Password anda berhasil direset');
    }
}
