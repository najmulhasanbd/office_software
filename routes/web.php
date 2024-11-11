<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    // return view('welcome');
    return view('auth.login');
});



Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [FrontendController::class, 'userDashboard'])->name('user.dashboard');

    Route::post('sales/store', [FrontendController::class, 'store'])->name('sales.store');

    Route::get('sales/list', [FrontendController::class, 'salesList'])->name('sales.list');
    Route::get('sales/report', [FrontendController::class, 'salesReport'])->name('sales.report');

    Route::get('sales/invoice/list', [FrontendController::class, 'salesInvoiceList'])->name('sales.invoice.list');
    Route::get('sales/invoice/show', [FrontendController::class, 'salesInvoiceShow'])->name('sales.invoice.show');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/sales/list', [AdminController::class, 'adminSalesList'])->name('admin.sales.list');
    Route::put('admin/sale/update/{id}', [AdminController::class, 'adminSaleUpdate'])->name('admin.sale.update');
    Route::post('/admin/sales/filter', [AdminController::class, 'filterSales'])->name('admin.sales.filter');
});
