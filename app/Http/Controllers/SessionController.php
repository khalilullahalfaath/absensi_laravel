<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class SessionController extends Controller
{
    function index()
    {
        return view('sessions/index');
    }

    function login(Request  $request)
    {
        //validation email and password must be required
        $request->validate([
            // check if email exist in the database
            //check if email not soft deleted
            'email' => 'required|email|exists:users,email|exists_not_soft_deleted',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi',
            'email.exists_not_soft_deleted' => 'Email telah dihapus oleh sistem. Silahkan hubungi admin untuk mengaktifkan akun anda',
            'email.exists' => 'Email tidak ditemukan',
            'password.required' => 'Password harus diisi'
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($infologin)) {
            // if login is successful, redirect to the appropriate page based on the user's role
            if (Auth::user()->role === 'admin') {
                return redirect(route('home.admin'))->with('success', 'Admin login successful');
            } else {
                return redirect(route('home.user'))->with('success', Auth::user()->nama . ' login successful');
            }
            exit();
        } else {
            return redirect('/sessions')->withErrors('Email or password is incorrect');
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('/sessions')->with('success', 'Logout berhasil');
    }

    function register()
    {
        // Menampilkan form register
        return view('sessions.register');
    }

    function create(Request  $request)
    {

        // validate all input must be required with custom error
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,',
            'password' => 'required|string|min:8',
            'no_presensi' => 'required|string|max:255|unique:users,no_presensi,',
            'asal_instansi' => 'required|string|max:255',
            'nama_unit_kerja' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ], [
            // custom error message

            'nama.required' => 'Nama harus diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'no_presensi.required' => 'Nomor presensi harus diisi',
            'no_presensi.unique' => 'Nomor presensi sudah terdaftar',
            'asal_instansi.required' => 'Asal instansi harus diisi',
            'asal_instansi.max' => 'Asal instansi maksimal 255 karakter',
            'nama_unit_kerja.required' => 'Nama unit kerja harus diisi',
            'nama_unit_kerja.max' => 'Nama unit kerja maksimal 255 karakter',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid'
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => 'user',
            'password' => Hash::make($request->password),
            'no_presensi' => $request->no_presensi,
            'asal_instansi' => $request->asal_instansi,
            'nama_unit_kerja' => $request->nama_unit_kerja,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir
        ];


        try {
            // Attempt to create a new user in the database
            User::create($data);

            // If the user is created successfully, you can redirect or do something else
            return redirect('/sessions')->with('success', 'Registration successful. You can now log in.');
        } catch (\Exception $e) {
            // If there's an error during the user creation, catch the exception
            // and handle the error accordingly (e.g., log the error, show an error message, etc.)
            // For debugging purposes, you can also use dd($e) to inspect the exception
            dd($e);
        }
    }
}
