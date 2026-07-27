<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WhatsAppCheckoutController;
use App\Http\Controllers\AdminApprovalController;

// Authentication routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [HomeController::class, 'products'])->name('home.products');
Route::get('/produk/{slug}', [HomeController::class, 'productDetail'])->name('home.product.detail');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('home.about');
Route::get('/hubungi-kami', [HomeController::class, 'contact'])->name('home.contact');
Route::post('/hubungi-kami', [HomeController::class, 'contactSubmit'])->name('home.contact.submit');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']); // For ease of logout testing

Route::post('/checkout/whatsapp', [WhatsAppCheckoutController::class, 'checkout'])->name('checkout.whatsapp');

// Protected routes (Only authenticated users can access)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Sales/POS terminal routes
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::post('/sales/payment', [SalesController::class, 'payment'])->name('sales.payment');
    Route::get('/sales/payment/cash', [SalesController::class, 'paymentCash'])->name('sales.payment.cash');
    Route::get('/sales/payment/qris', [SalesController::class, 'paymentQris'])->name('sales.payment.qris');
    Route::post('/sales/checkout', [SalesController::class, 'checkout'])->name('sales.checkout');
    Route::get('/sales/success/{transaction}', [SalesController::class, 'success'])->name('sales.success');

    // Product & Category Management CRUD routes
    Route::resource('/products', ProductController::class);
    Route::post('/products/categories', [ProductController::class, 'storeCategory'])->name('products.categories.store');
    Route::put('/products/categories/{category}', [ProductController::class, 'updateCategory'])->name('products.categories.update');
    Route::delete('/products/categories/{category}', [ProductController::class, 'destroyCategory'])->name('products.categories.destroy');

    // Unit Product CRUD routes
    Route::post('/products/units', [ProductController::class, 'storeUnit'])->name('products.units.store');
    Route::put('/products/units/{unit}', [ProductController::class, 'updateUnit'])->name('products.units.update');
    Route::delete('/products/units/{unit}', [ProductController::class, 'destroyUnit'])->name('products.units.destroy');

    // Report & Wawasan routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // WhatsApp Approval routes
    Route::get('/admin/approvals', [AdminApprovalController::class, 'index'])->name('admin.approvals.index');
    Route::get('/admin/approvals/{transaction}', [AdminApprovalController::class, 'show'])->name('admin.approvals.show');
    Route::post('/admin/approvals/{transaction}/approve', [AdminApprovalController::class, 'approve'])->name('admin.approvals.approve');
    Route::post('/admin/approvals/{transaction}/reject', [AdminApprovalController::class, 'reject'])->name('admin.approvals.reject');
});
