<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ProfitCalculationController;
use Illuminate\Support\Facades\Route;

// 🌐 Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [HomeController::class, 'products'])->name('products');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');

// Tambahkan route testimonial untuk frontend
Route::get('/testimonial', [HomeController::class, 'testimonial'])->name('testimonial');
Route::get('/testimoni', [HomeController::class, 'testimonial'])->name('testimoni'); // alias

// 🔒 Admin Routes (protected)
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('/products', ProductController::class);

    // Transactions - Main resource route
    Route::resource('/transactions', TransactionController::class);
    
    // Additional transaction routes for smart cashier features
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/{id}/print', [TransactionController::class, 'printReceipt'])->name('print');
        Route::get('/today/sales', [TransactionController::class, 'getTodaySales'])->name('today.sales');
        Route::get('/product/{id}', [TransactionController::class, 'getProduct'])->name('product.get');
        
        // Tambahkan route baru untuk fitur tambahan - menggunakan GET untuk memudahkan
        Route::get('/{id}/confirm-payment', [TransactionController::class, 'confirmPayment'])->name('confirm-payment');
        Route::get('/{id}/cancel', [TransactionController::class, 'cancelTransaction'])->name('cancel');
        Route::get('/filter/berat', [TransactionController::class, 'filterByBerat'])->name('filter-berat');
        Route::get('/berat/stats', [TransactionController::class, 'getBeratStats'])->name('berat-stats');
    });

    // Testimonials
    Route::resource('/testimonials', TestimonialController::class);
    Route::post('/testimonials/{testimonial}/toggle-status', [TestimonialController::class, 'toggleStatus'])
        ->name('testimonials.toggle-status');

    // Reports Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');

    // Profit Calculation Routes
    Route::prefix('profit')->name('profit.')->group(function () {
        Route::get('/', [ProfitCalculationController::class, 'index'])->name('index');
        Route::post('/calculate', [ProfitCalculationController::class, 'calculate'])->name('calculate');
        Route::post('/calculate-from-transactions', [ProfitCalculationController::class, 'calculateFromTransactions'])->name('calculate-from-transactions');
        Route::get('/{profit}', [ProfitCalculationController::class, 'show'])->name('show');
        Route::delete('/{profit}', [ProfitCalculationController::class, 'destroy'])->name('destroy');
        Route::get('/quick-stats', [ProfitCalculationController::class, 'getQuickStats'])->name('quick-stats');
    });

    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/', [SettingController::class, 'update'])->name('settings.update');

        // Receipt Settings
        Route::get('/receipt-settings', [SettingController::class, 'getReceiptSettings'])->name('settings.receipt-settings');

        // Backup
        Route::get('/backup', [SettingController::class, 'backup'])->name('settings.backup');
        Route::post('/backup/process', [SettingController::class, 'processBackup'])->name('settings.process-backup');
        Route::get('/backup/download/{filename}', [SettingController::class, 'downloadBackup'])->name('settings.download-backup');

        // Cache
        Route::get('/clear-cache', [SettingController::class, 'clearCache'])->name('settings.clear-cache');
        Route::post('/clear-cache/process', [SettingController::class, 'processClearCache'])->name('settings.process-clear-cache');

        // Optimize
        Route::get('/optimize', [SettingController::class, 'optimize'])->name('settings.optimize');
        Route::post('/optimize/process', [SettingController::class, 'processOptimize'])->name('settings.process-optimize');

        // Reset Data
        Route::get('/reset-data', [SettingController::class, 'resetData'])->name('settings.reset-data');
        Route::post('/reset-data/process', [SettingController::class, 'processResetData'])->name('settings.process-reset-data');
    });
});

// Redirect user ke dashboard admin setelah login
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

// Custom logout route
Route::post('/custom-logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('custom.logout');

require __DIR__.'/auth.php';