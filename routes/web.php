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
})->middleware('auth');

Route::get('/home', function () {
    return view('home');
})->middleware('auth');;


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
Route::get('/attendance/all-data', [AttendanceController::class, 'showAllData'])->name('attendance.allData')->middleware('auth');

Route::get('/print/checkin/csv/{id}', 'AttendanceController@printCheckInToCSV')->name('print.checkin.csv')->middleware('auth');
Route::get('/print/checkout/csv/{id}', 'AttendanceController@printCheckOutToCSV')->name('print.checkout.csv')->middleware('auth');
Route::get('/print/record/csv/{id}', 'AttendanceController@printRecordToCSV')->name('print.record.csv')->middleware('auth');

Route::get('print/checkin/csv', 'AttendanceController@printAllCheckInToCSV')->name('print.allcheckin.csv')->middleware('auth');
Route::get('print/checkout/csv', 'AttendanceController@printAllCheckoutToCSV')->name('print.allcheckout.csv')->middleware('auth');
Route::get('print/records/csv', 'AttendanceController@printAllRecordToCSV')->name('print.allrecords.csv')->middleware('auth');

// DASHBOARD

Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware('auth');
