<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

// Route::get('/home2', function () {
//     return view('view2');
// });

Route::middleware('auth')->get('/attendance', function () {
    return view('attendance.index');
});

Route::get('/registration', function () {
    return view('sessions.register');
});

Route::get('/sessions', 'SessionController@index')->name('sessions');;
Route::post('/sessions/login', 'SessionController@login');
Route::post('/sessions/logout', 'SessionController@logout')->middleware('auth');
