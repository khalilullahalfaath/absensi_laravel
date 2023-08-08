<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;

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

// group sessions endpoint
Route::group(['prefix' => 'sessions'], function () {
    Route::get('/', [SessionController::class, 'index'])->name('sessions');
    Route::post('/login', [SessionController::class, 'login']);
    Route::post('/logout', [SessionController::class, 'logout'])->middleware('auth');
    Route::get('/register', [SessionController::class, 'register']);
    Route::post('/create', [SessionController::class, 'create']);

    // group verify endpoint
    Route::get('/home', [AuthController::class, 'home'])->middleware(['auth', 'verify_email'])->name('home.user');
    Route::get('/verify/{token}', [AuthController::class, 'verifyAccount'])->name('user.verify');
});



// group auth middleware
Route::group(['middleware' => 'auth'], function () {
    // group user endpoint
    Route::group(['prefix' => 'user'], function () {
        // group attendance endpoint
        Route::group(['prefix' => 'attendance'], function () {
            Route::get('/', [AttendanceController::class, 'attendance'])->name('user.attendance');
            Route::post('/create', [AttendanceController::class, 'create'])->name('user.attendance.create');
            Route::get('/all-data', [AttendanceController::class, 'showAllData'])->name('user.attendance.allData');

            // export to csv only one data
            Route::get('/print/checkin/csv/{id}', [AttendanceController::class, 'printCheckInToCSV'])->name('print.checkin.csv');
            Route::get('/print/checkout/csv/{id}', [AttendanceController::class, 'printCheckOutToCSV'])->name('print.checkout.csv');
            Route::get('/print/record/csv/{id}', [AttendanceController::class, 'printRecordToCSV'])->name('print.record.csv');

            // export to csv all data
            Route::get('print/checkin/csv', [AttendanceController::class, 'printAllCheckInToCSV'])->name('print.allcheckin.csv');
            Route::get('print/checkout/csv', [AttendanceController::class, 'printAllCheckoutToCSV'])->name('print.allcheckout.csv');
            Route::get('print/records/csv', [AttendanceController::class, 'printAllRecordToCSV'])->name('print.allrecords.csv');
        });
    });

    // group admin endpoint
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('home.admin');

        // group user endpoint
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'showAllData'])->name('admin.users');
            Route::get('/{user}/edit', [UserController::class, 'editUser'])->name('admin.users.edit');
            Route::put('/{user}', [UserController::class, 'updateUser'])->name('admin.users.update');
            Route::get('/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

            // export to csv all data
            Route::get('/export', [UserController::class, 'printAllUsersToCSV'])->name('print.students.csv');
        });

        // group attendance endpoint
        Route::group(['prefix' => 'attendance'], function () {
            Route::get('/', [AdminController::class, 'adminAttendance'])->name('admin.attendance');

            // export to csv all data
            Route::get('/checkin/export', [AdminController::class, 'printAllCheckinRecordsToCSV'])->name('admin.print.allcheckin.csv');
            Route::get('/checkout/export', [AdminController::class, 'printAllCheckoutRecordsToCSV'])->name('admin.print.allcheckout.csv');
            Route::get('/records/export', [AdminController::class, 'printAllRecordsToCSV'])->name('admin.print.allrecords.csv');

            // destroy data
            Route::get('/checkin/{id}', [AdminController::class, 'destroyCheckin'])->name('admin.attendance.checkin.destroy');
            Route::get('/checkout/{id}', [AdminController::class, 'destroyCheckout'])->name('admin.attendance.checkout.destroy');
            Route::get('/records/{id}', [AdminController::class, 'destroyRecord'])->name('admin.attendance.records.destroy');
        });
    });
});
