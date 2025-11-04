<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
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
Route::prefix('admin')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Products
    Route::resource('/products', ProductController::class)->names('admin.products');

    // Transactions
    Route::resource('/transactions', TransactionController::class)
        ->names('admin.transactions')
        ->except(['show', 'edit']);

    // Testimonials
    Route::resource('/testimonials', TestimonialController::class)
        ->names('admin.testimonials');
    Route::post('/testimonials/{testimonial}/toggle-status', [TestimonialController::class, 'toggleStatus'])
        ->name('admin.testimonials.toggle-status');

    // Reports
    Route::prefix('reports')->name('admin.reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/daily', [ReportController::class, 'daily'])->name('daily');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
    });

    // Settings
    Route::prefix('settings')->name('admin.settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/', [SettingController::class, 'update'])->name('update');

        // Backup
        Route::get('/backup', [SettingController::class, 'backup'])->name('backup');
        Route::post('/backup/process', [SettingController::class, 'processBackup'])->name('process-backup');
        Route::get('/backup/download/{filename}', [SettingController::class, 'downloadBackup'])->name('download-backup');

        // Cache
        Route::get('/clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');
        Route::post('/clear-cache/process', [SettingController::class, 'processClearCache'])->name('process-clear-cache');

        // Optimize
        Route::get('/optimize', [SettingController::class, 'optimize'])->name('optimize');
        Route::post('/optimize/process', [SettingController::class, 'processOptimize'])->name('process-optimize');

        // Reset Data
        Route::get('/reset-data', [SettingController::class, 'resetData'])->name('reset-data');
        Route::post('/reset-data/process', [SettingController::class, 'processResetData'])->name('process-reset-data');
    });
});

// Redirect user ke dashboard admin setelah login
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';