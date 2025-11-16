<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\ProfitCalculationController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
        Route::get('/today-sales', [TransactionController::class, 'getTodaySales'])->name('today-sales');
        Route::get('/get-product/{id}', [TransactionController::class, 'getProduct'])->name('get-product');
        
        // Tambahkan route baru untuk fitur tambahan - menggunakan GET untuk memudahkan
        Route::get('/{id}/confirm-payment', [TransactionController::class, 'confirmPayment'])->name('confirm-payment');
        Route::get('/{id}/cancel', [TransactionController::class, 'cancelTransaction'])->name('cancel');
        
        // Route untuk statistik berat (jika diperlukan)
        Route::get('/berat/stats', [TransactionController::class, 'getBeratStats'])->name('berat-stats');
    });

    // Gallery Routes
    Route::resource('/gallery', GalleryController::class);
    Route::post('/gallery/update-order', [GalleryController::class, 'updateOrder'])
         ->name('gallery.update-order');

    // Testimonials
    Route::resource('/testimonials', TestimonialController::class);
    Route::post('/testimonials/{testimonial}/toggle-status', [TestimonialController::class, 'toggleStatus'])
        ->name('testimonials.toggle-status');

    // Reports Routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports/daily', [ReportController::class, 'daily'])->name('reports.daily');

    // Profit Calculation Routes - SESUAI dengan struktur yang diberikan
    Route::prefix('profit')->group(function () {
        Route::get('/', [ProfitCalculationController::class, 'index'])->name('profit.index');
        Route::get('/get-revenue-data', [ProfitCalculationController::class, 'getRevenueData'])->name('profit.get-revenue-data');
        Route::get('/get-expenses-data', [ProfitCalculationController::class, 'getExpensesData'])->name('profit.get-expenses-data');
        Route::post('/add-expense', [ProfitCalculationController::class, 'addExpense'])->name('profit.add-expense');
        Route::get('/get-expense/{id}', [ProfitCalculationController::class, 'getExpense'])->name('profit.get-expense');
        Route::put('/update-expense/{id}', [ProfitCalculationController::class, 'updateExpense'])->name('profit.update-expense');
        Route::delete('/delete-expense/{id}', [ProfitCalculationController::class, 'deleteExpense'])->name('profit.delete-expense');
        Route::post('/calculate', [ProfitCalculationController::class, 'calculate'])->name('profit.calculate');
        Route::get('/{profit}', [ProfitCalculationController::class, 'show'])->name('profit.show');
        Route::delete('/{profit}', [ProfitCalculationController::class, 'destroy'])->name('profit.destroy');
        
        // Tambahan routes yang ada di kode asli
        Route::get('/quick-stats', [ProfitCalculationController::class, 'getQuickStats'])->name('profit.quick-stats');
    });

    // Contact Management Routes
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [AdminContactController::class, 'index'])->name('index');
        Route::get('/{contact}', [AdminContactController::class, 'show'])->name('show');
        Route::put('/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{contact}', [AdminContactController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [AdminContactController::class, 'bulkAction'])->name('bulk-action');
    });

    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::put('/', [SettingController::class, 'update'])->name('update');

        // Receipt Settings
        Route::get('/receipt-settings', [SettingController::class, 'getReceiptSettings'])->name('receipt-settings');

        // Backup
        Route::post('/backup', [SettingController::class, 'backup'])->name('backup');
        Route::get('/backup/download/{filename}', [SettingController::class, 'downloadBackup'])->name('download-backup');

        // Cache
        Route::post('/clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');

        // Optimize
        Route::post('/optimize', [SettingController::class, 'optimize'])->name('optimize');

        // Reset Data
        Route::post('/reset-data', [SettingController::class, 'resetData'])->name('reset-data');
    });
});

// Frontend Contact Routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

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