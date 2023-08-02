<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
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


Route::get('/sessions', [SessionController::class, 'index'])->name('sessions');;
Route::post('/sessions/login', [SessionController::class, 'login']);
Route::post('/sessions/logout', [SessionController::class, 'logout'])->middleware('auth');
Route::get('/sessions/register', [SessionController::class, 'register']);
Route::post('/sessions/create', [SessionController::class, 'create']);

Route::get('/attendance', [AttendanceController::class, 'attendance'])->middleware('auth');
Route::post('/attendance/create', [AttendanceController::class, 'create'])->middleware('auth');
Route::get('/attendance/all-data', [AttendanceController::class, 'showAllData'])->name('attendance.allData')->middleware('auth');

Route::get('/print/checkin/csv/{id}', [AttendanceController::class, 'printCheckInToCSV'])->name('print.checkin.csv')->middleware('auth');
Route::get('/print/checkout/csv/{id}', [AttendanceController::class, 'printCheckOutToCSV'])->name('print.checkout.csv')->middleware('auth');
Route::get('/print/record/csv/{id}', [AttendanceController::class, 'printRecordToCSV'])->name('print.record.csv')->middleware('auth');

Route::get('print/checkin/csv', [AttendanceController::class, 'printAllCheckInToCSV'])->name('print.allcheckin.csv')->middleware('auth');
Route::get('print/checkout/csv', [AttendanceController::class, 'printAllCheckoutToCSV'])->name('print.allcheckout.csv')->middleware('auth');
Route::get('print/records/csv', [AttendanceController::class, 'printAllRecordToCSV'])->name('print.allrecords.csv')->middleware('auth');

// ADMIN
Route::get('/home/admin', [AdminController::class, 'index'])->name('home.admin')->middleware('auth');

Route::get('/admin/users', [UserController::class, 'showAllData'])->name('admin.users')->middleware('auth');
Route::get('admin/users/{user}/edit', [UserController::class, 'editUser'])->name('admin.users.edit')->middleware('auth');
Route::put('admin/users/{user}', [UserController::class, 'updateUser'])->name('admin.users.update')->middleware('auth');
Route::get('/admin/users/delete/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy')->middleware('auth');
Route::get('/admin/users/print/records/csv', [UserController::class, 'printAllUsersToCSV'])->name('print.students.csv')->middleware('auth');


// Admin Attendance
// Route for the admin page
Route::get('/admin/attendance', [AdminController::class, 'adminAttendance'])->name('admin.attendance')->middleware('auth');
// Route for the search functionality
Route::get('/admin/search', [AdminController::class, 'searchUsers'])->name('admin.search')->middleware('auth');

// Route for the admin attendance page
Route::get('admin/attendance/checkin/export', [AdminController::class, 'printAllCheckinRecordsToCSV'])->name('admin.print.allcheckin.csv')->middleware('auth');
Route::get('admin/attendance/checkout/export', [AdminController::class, 'printAllCheckoutRecordsToCSV'])->name('admin.print.allcheckout.csv')->middleware('auth');
Route::get('admin/attendance/record/export', [AdminController::class, 'printAllRecordsToCSV'])->name('admin.print.allrecords.csv')->middleware('auth');

Route::get('admin/attendance/checkin/{id}', [AdminController::class, 'destroyCheckIn'])->name('admin.checkin.destroy')->middleware('auth');
Route::get('admin/attendance/checkout/{id}', [AdminController::class, 'destroyCheckOut'])->name('admin.checkout.destroy')->middleware('auth');
Route::get('admin/attendance/record/{id}', [AdminController::class, 'destroyRecord'])->name('admin.record.destroy')->middleware('auth');
