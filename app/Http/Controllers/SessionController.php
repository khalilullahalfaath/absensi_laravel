<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    function index(){
        return view('sessions/index');
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
            return redirect('home')->with('success', 'Login berhasil');
            if (Auth::user()->role == 0) {
                return redirect('admin.index')->with('success', 'Login berhasil');
            } else {
                return redirect('home')->with('success', 'Login berhasil');
            }
        }else{
            return redirect('sessions')->withErrors('Email atau password salah');
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('sessions')->with('success', 'Logout berhasil');
    }

    function register()
    {
        // Menampilkan form register
        return view('sessions.register');
    }

    function create(Request  $request){
        // dd($request->all());
        $request->session()->flash('nama', $request->nama);
        $request->session()->flash('email', $request->email);
        $request->session()->flash('password', $request->password);
        $request->session()->flash('asal_instansi', $request->asal_instansi);
        $request->session()->flash('nama_unit_kerja', $request->nama_unit_kerja);
        $request->session()->flash('jenis_kelamin', $request->jenis_kelamin);
        $request->session()->flash('tanggal_lahir', $request->tanggal_lahir);

        // validate all input must be required with custom error
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'asal_instansi' => 'required',
            'nama_unit_kerja' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required'
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'asal_instansi.required' => 'Asal instansi harus diisi',
            'nama_unit_kerja.required' => 'Nama unit kerja harus diisi',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi'
        ]);
        
        
        // dd($request->all());
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role'=> 1,
            'password' => Hash::make($request->password),
            'asal_instansi' => $request->asal_instansi,
            'nama_unit_kerja' => $request->nama_unit_kerja,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir
        ];

        // dd($request->all());
        User::create($data);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];
    
        // dd($infologin);
        if(Auth::attempt($infologin)){
            // if success
            return redirect('home')->with('success', Auth::user()->nama . ' login berhasil');
        }else{
            return redirect('sessions')->withErrors('Email atau password salah');
        }

    }
}
