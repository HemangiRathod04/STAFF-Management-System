<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\StaffLoginController;
use Illuminate\Support\Facades\Route;

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
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/staff-list', [AdminController::class, 'staffList'])->name('admin.staff-list');

    Route::get('admin/add-staff', [AdminController::class, 'createStaff'])->name('admin.add-staff');
    Route::post('admin/add-staff', [AdminController::class, 'storeStaff']);

    Route::get('admin/edit-staff/{id}', [AdminController::class, 'editStaff'])->name('admin.edit-staff');
    Route::post('admin/update-staff/{id}', [AdminController::class, 'updateStaff'])->name('admin.update-staff');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/staff-login', function () {
    return view('admin.staff-login');
})->name('login.staff');
Route::post('/staff-login', [StaffLoginController::class, 'login'])->name('staff.login');

Route::get('/staff-register', function () {
    return view('admin.staff-register');
})->name('staff.register');
Route::post('/staff-register', [AdminController::class, 'storeStaff'])->name('staff.register.submit');

Route::get('/staff/dashboard', [StaffLoginController::class, 'dashboard'])->name('staff.dashboard');
Route::post('/staff/clock-in', [StaffLoginController::class, 'clockIn'])->name('staff.clock_in');
Route::post('/staff/clock-out', [StaffLoginController::class, 'clockOut'])->name('staff.clock_out');


