<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AttendanceController;

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



Route::get('/sessions', 'SessionController@index')->name('sessions');;
Route::post('/sessions/login', 'SessionController@login');
Route::post('/sessions/logout', 'SessionController@logout')->middleware('auth');
Route::get('/sessions/register', 'SessionController@register');
Route::post('/sessions/create', 'SessionController@create');

Route::get('/attendance', 'AttendanceController@attendance')->middleware('auth');
Route::post('/attendance/create', 'AttendanceController@create')->middleware('auth');
Route::get('/attendance/all-data', [AttendanceController::class, 'showAllData'])->name('attendance.allData');

