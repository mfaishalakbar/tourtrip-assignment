<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminStaffsController;
use App\Http\Controllers\AdminCustomersController;
use App\Http\Controllers\AdminCitiesController;
use App\Http\Controllers\AdminHotelsController;
use App\Http\Controllers\AdminTripsController;
use App\Http\Controllers\AdminTransactionsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ---- Public ------
Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [HomeController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthenticationController::class, 'login'])->middleware('guest');
Route::get('/logout', [AuthenticationController::class, 'logout'])->middleware('auth');
Route::get('/register', [HomeController::class, 'register'])->middleware('guest');
Route::post('/register', [AuthenticationController::class, 'register'])->middleware('guest');
Route::get('/reset-password', [HomeController::class, 'reset_password'])->middleware('guest');
Route::post('/reset-password', [AuthenticationController::class, 'reset_password'])->middleware('guest');
Route::get('/reset-password/confirm', [HomeController::class, 'reset_password_confirm'])->middleware('guest');
Route::post('/reset-password/confirm', [AuthenticationController::class, 'reset_password_confirm'])->middleware('guest');


Route::get('/search', [HomeController::class, 'search']);
Route::post('/search', [HomeController::class, 'submitTransaction']);
Route::get('/transaction', [HomeController::class, 'listTransaction'])->name('public.transaction');
Route::get('/transaction/{id}', [HomeController::class, 'detailTransaction']);

// ---- Admin Panel -----
// Login and Logout
Route::get('/admin/auth/login', [AdminAuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/admin/auth/login', [AdminAuthController::class, 'submitLogin'])->middleware('guest')->name('login.submit');
Route::get('/admin/auth/logout', [AdminAuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/admin/auth/logout', [AdminAuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('internal-only')->group(function () {
    // Dashboard
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Staff
    Route::get('/admin/staff', [AdminStaffsController::class, 'index'])->name('staffs.index')->middleware('auth');
    Route::get('/admin/staff/add', [AdminStaffsController::class, 'add'])->name('staffs.add')->middleware('auth');
    Route::post('/admin/staff/add', [AdminStaffsController::class, 'submitAdd'])->name('staffs.add.submit')->middleware('auth');
    Route::get('/admin/staff/{id}/edit', [AdminStaffsController::class, 'edit'])->name('staffs.edit')->middleware('auth');
    Route::post('/admin/staff/{id}/edit', [AdminStaffsController::class, 'submitEdit'])->name('staffs.edit.submit')->middleware('auth');
    Route::get('/admin/staff/{id}/delete', [AdminStaffsController::class, 'delete'])->name('staffs.delete')->middleware('auth');

    // Customer
    Route::get('/admin/customer', [AdminCustomersController::class, 'index'])->name('customers.index')->middleware('auth');
    Route::get('/admin/customer/add', [AdminCustomersController::class, 'add'])->name('customers.add')->middleware('auth');
    Route::post('/admin/customer/add', [AdminCustomersController::class, 'submitAdd'])->name('customers.add.submit')->middleware('auth');
    Route::get('/admin/customer/{id}/edit', [AdminCustomersController::class, 'edit'])->name('customers.edit')->middleware('auth');
    Route::post('/admin/customer/{id}/edit', [AdminCustomersController::class, 'submitEdit'])->name('customers.edit.submit')->middleware('auth');
    Route::get('/admin/customer/{id}/delete', [AdminCustomersController::class, 'delete'])->name('customers.delete')->middleware('auth');

    // Cities
    Route::get('/admin/city', [AdminCitiesController::class, 'index'])->name('cities.index')->middleware('auth');
    Route::get('/admin/city/add', [AdminCitiesController::class, 'add'])->name('cities.add')->middleware('auth');
    Route::post('/admin/city/add', [AdminCitiesController::class, 'submitAdd'])->name('cities.add.submit')->middleware('auth');
    Route::get('/admin/city/{id}/edit', [AdminCitiesController::class, 'edit'])->name('cities.edit')->middleware('auth');
    Route::post('/admin/city/{id}/edit', [AdminCitiesController::class, 'submitEdit'])->name('cities.edit.submit')->middleware('auth');
    Route::get('/admin/city/{id}/delete', [AdminCitiesController::class, 'delete'])->name('cities.delete')->middleware('auth');

    // Trips
    Route::get('/admin/trip', [AdminTripsController::class, 'index'])->name('trips.index')->middleware('auth');
    Route::get('/admin/trip/add', [AdminTripsController::class, 'add'])->name('trips.add')->middleware('auth');
    Route::post('/admin/trip/add', [AdminTripsController::class, 'submitAdd'])->name('trips.add.submit')->middleware('auth');
    Route::get('/admin/trip/{id}/edit', [AdminTripsController::class, 'edit'])->name('trips.edit')->middleware('auth');
    Route::post('/admin/trip/{id}/edit', [AdminTripsController::class, 'submitEdit'])->name('trips.edit.submit')->middleware('auth');
    Route::get('/admin/trip/{id}/delete', [AdminTripsController::class, 'delete'])->name('trips.delete')->middleware('auth');

    // Hotels
    Route::get('/admin/hotel', [AdminHotelsController::class, 'index'])->name('hotels.index')->middleware('auth');
    Route::get('/admin/hotel/add', [AdminHotelsController::class, 'add'])->name('hotels.add')->middleware('auth');
    Route::post('/admin/hotel/add', [AdminHotelsController::class, 'submitAdd'])->name('hotels.add.submit')->middleware('auth');
    Route::get('/admin/hotel/{id}/edit', [AdminHotelsController::class, 'edit'])->name('cities.edit')->middleware('auth');
    Route::post('/admin/hotel/{id}/edit', [AdminHotelsController::class, 'submitEdit'])->name('hotels.edit.submit')->middleware('auth');
    Route::get('/admin/hotel/{id}/delete', [AdminHotelsController::class, 'delete'])->name('hotels.delete')->middleware('auth');

    // Transaction
    Route::get('/admin/transaction', [AdminTransactionsController::class, 'index'])->name('transactions.index')->middleware('auth');
    Route::get('/admin/transaction/pending', [AdminTransactionsController::class, 'indexPending'])->name('transactions.index.pending')->middleware('auth');
    Route::get('/admin/transaction/add', [AdminTransactionsController::class, 'add'])->name('transactions.add')->middleware('auth');
    Route::post('/admin/transaction/add', [AdminTransactionsController::class, 'submitAdd'])->name('transactions.add.submit')->middleware('auth');
    Route::get('/admin/transaction/{id}/view', [AdminTransactionsController::class, 'view'])->name('transactions.view')->middleware('auth');
    Route::get('/admin/transaction/{id}/revoke', [AdminTransactionsController::class, 'delete'])->name('transactions.delete')->middleware('auth');
    Route::get('/admin/transaction/{id}/approve', [AdminTransactionsController::class, 'approve'])->name('transactions.delete')->middleware('auth');
});
