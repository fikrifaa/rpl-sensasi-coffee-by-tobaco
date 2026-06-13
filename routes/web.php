<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryController; // Memperbaiki typo 'Use' menjadi 'use'
use App\Http\Controllers\DiscountController;
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

// Halaman Login Utama (Kembali ke kosongan tanpa memajak nama route 'login')
Route::get('/', function () {
    return view('pages.auth.login');
});

// --- MENUMPAS DAN MEMBLOKIR JALUR REGISTRASI (SISTEM INTERNAL KAFE) ---
Route::get('/register', function () {
    return redirect('/');
});
Route::post('/register', function () {
    return redirect('/');
});

// Semua Menu Harus Login Terlebih Dahulu (Fitur Internal Kafe)
Route::middleware(['auth'])->group(function() {
    
    // Dashboard Utama (Bisa diakses semua Role)
    Route::get('home', function(){
        return view('pages.dashboard');
    })->name('home');

    /* |--------------------------------------------------------------------------
    | 1. MENU KHUSUS: ADMIN / OWNER
    |--------------------------------------------------------------------------
    */
    Route::resource('user', UserController::class);
    Route::resource('employee', EmployeeController::class);
    
    /* |--------------------------------------------------------------------------
    | 2. MENU MASTER DATA: ADMIN (FULL), KASIR & GUDANG (READ-ONLY)
    |--------------------------------------------------------------------------
    */
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('discount', DiscountController::class);

    /* |--------------------------------------------------------------------------
    | 3. MENU OPERASIONAL POS: KASIR (`staff`) & ADMIN
    |--------------------------------------------------------------------------
    */
    Route::resource('order', OrderController::class);
    Route::resource('reservation', ReservationController::class);
    Route::resource('customer', CustomerController::class);

    /* |--------------------------------------------------------------------------
    | 4. MENU LOGISTIK/WAREHOUSE: STAFF GUDANG (`user`) & ADMIN
    |--------------------------------------------------------------------------
    */
    Route::resource('supplier', SupplierController::class);
    Route::resource('inventory', InventoryController::class);

});