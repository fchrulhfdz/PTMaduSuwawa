<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();

        return view('admin.settings.index', compact('settings', 'totalProducts', 'totalTransactions'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'receipt_header' => 'nullable|string',
            'receipt_footer' => 'nullable|string',
            'receipt_printer_width' => 'nullable|integer|min:32|max:80',
            'print_automatically' => 'nullable|boolean',
            'low_stock_threshold' => 'nullable|integer|min:1',
            'enable_stock_notifications' => 'nullable|boolean',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    // Method untuk mengambil pengaturan struk
    public function getReceiptSettings()
    {
        // Gunakan model Setting langsung untuk mengambil data
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return response()->json([
            'header' => $settings['receipt_header'] ?? 'SMART CASHIER\nSistem Kasir Pintar',
            'footer' => $settings['receipt_footer'] ?? 'Terima kasih atas kunjungan Anda\n*** Struk ini sebagai bukti pembayaran ***',
            'printer_width' => $settings['receipt_printer_width'] ?? 42,
            'print_automatically' => isset($settings['print_automatically']) ? (bool)$settings['print_automatically'] : false
        ]);
    }

    public function backup()
    {
        try {
            Artisan::call('backup:run', ['--only-db' => true]);
            return redirect()->route('admin.settings.index')->with('success', 'Backup database berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            return redirect()->route('admin.settings.index')->with('success', 'Cache berhasil dibersihkan.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')->with('error', 'Gagal membersihkan cache: ' . $e->getMessage());
        }
    }

    public function optimize()
    {
        try {
            Artisan::call('optimize');
            return redirect()->route('admin.settings.index')->with('success', 'Aplikasi berhasil dioptimasi.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')->with('error', 'Gagal mengoptimasi aplikasi: ' . $e->getMessage());
        }
    }

    public function resetData()
    {
        try {
            DB::beginTransaction();
            Transaction::truncate();
            DB::commit();
            return redirect()->route('admin.settings.index')->with('success', 'Semua data transaksi berhasil direset.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.settings.index')->with('error', 'Gagal mereset data: ' . $e->getMessage());
        }
    }

    // Tambahkan method untuk proses backup, clear cache, optimize, dan reset data
    public function processBackup(Request $request)
    {
        return $this->backup();
    }

    public function processClearCache(Request $request)
    {
        return $this->clearCache();
    }

    public function processOptimize(Request $request)
    {
        return $this->optimize();
    }

    public function processResetData(Request $request)
    {
        return $this->resetData();
    }

    public function downloadBackup($filename)
    {
        $path = storage_path('app/backups/' . $filename);
        
        if (file_exists($path)) {
            return response()->download($path);
        }
        
        return redirect()->route('admin.settings.index')->with('error', 'File backup tidak ditemukan.');
    }
}