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
            'company_address' => 'nullable|string|max:500',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'receipt_header' => 'nullable|string|max:500',
            'receipt_footer' => 'nullable|string|max:500',
            'receipt_printer_width' => 'required|integer|min:32|max:80',
            'low_stock_threshold' => 'required|integer|min:1',
        ]);

        $validated['print_automatically'] = $request->has('print_automatically') ? 1 : 0;
        $validated['enable_stock_notifications'] = $request->has('enable_stock_notifications') ? 1 : 0;

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil diperbarui.');
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
}
