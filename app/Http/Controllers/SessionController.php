<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SessionController;

class SessionController extends Controller
{
    function index(){
        return view('sessions.index');
    }

    function login(Request  $request){

        $request->session()->flash('email', $request->email);
        //validation email and password must be required
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];
    

        if(Auth::attempt($infologin)){
            // if success
            return redirect('attendance')->with('success', 'Login berhasil');
        }else{
            return redirect('sessions')->withErrors('Email atau password salah');
        }
    }
}
