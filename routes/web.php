<?php

use Illuminate\Support\Facades\Route;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryItemController; 
use App\Http\Controllers\BorrowingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $organizations = Organization::all();
    return view('welcome', compact('organizations'));
})->name('welcome');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    throw ValidationException::withMessages([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->name('login.attempt');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tambahkan resource route untuk Organisasi di dalam middleware 'auth', termasuk 'show'
    Route::resource('organizations', OrganizationController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy', 'show']);

    // Routes untuk Manajemen Pengguna (Admin)
    Route::resource('users', UserController::class);

    // Rute untuk impersonasi/login sebagai admin organisasi
    // PENTING: Rute leaveImpersonation HARUS di atas rute impersonate/{user}
    Route::post('/impersonate/leave', [App\Http\Controllers\UserController::class, 'leaveImpersonation'])->name('users.leaveImpersonation');
    Route::post('/impersonate/{user}', [App\Http\Controllers\UserController::class, 'impersonate'])->name('users.impersonate');

    // Rute baru untuk Barang Terbaru (HARUS DI ATAS resource route)
    Route::get('/inventory_items/recent', [InventoryItemController::class, 'recentItems'])->name('inventory_items.recent');

    // START: Rute untuk Manajemen Inventaris Barang
    Route::resource('inventory_items', InventoryItemController::class);
    // END: Rute untuk Manajemen Inventaris Barang

    // Rute spesifik untuk Borrowing (HARUS DI ATAS resource route borrowings)
    Route::get('/borrowings/history', [BorrowingController::class, 'history'])->name('borrowings.history');

    // Borrowing Transactions (akses terbatas berdasarkan role dan organisasi)
    // Ditempatkan setelah inventory_items karena sering berinteraksi dengannya
    Route::resource('borrowings', BorrowingController::class);

});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');