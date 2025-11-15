@extends('layouts.admin')

@section('title', 'Manajemen Produk - Smart Cashier')
@section('subtitle', 'Kelola semua produk Anda di satu tempat')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Produk</h1>
                <p class="mt-2 text-sm text-gray-600">Kelola semua produk Anda di satu tempat</p>
            </div>
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i>
                Tambah Produk
            </a>
        </div>
    </div>

    <!-- Alert Section -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                        <!-- KOLOM KATEGORI DIHAPUS -->
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Berat</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($product->image)
                                        <div class="h-12 w-12 rounded-xl bg-gray-100 p-0.5">
                                            <img class="h-full w-full rounded-lg object-cover" 
                                                 src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}">
                                        </div>
                                    @else
                                        <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-box text-blue-600 text-lg"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500 truncate mt-1">{{ Str::limit($product->description, 50) }}</p>
                                </div>
                            </div>
                        </td>
                        <!-- SEL KATEGORI DIHAPUS -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="text-sm font-semibold text-gray-900 {{ $product->stock < 10 ? 'text-red-600' : '' }}">
                                    {{ $product->stock }}
                                </div>
                                @if($product->stock < 10)
                                    <i class="fas fa-exclamation-triangle text-red-400 ml-2 text-sm"></i>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                @if($product->berat_isi && $product->satuan_berat)
                                    {{ $product->berat_isi }} {{ $product->satuan_berat }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="inline-flex items-center justify-center p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-200 hover:scale-105">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center p-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-200 hover:scale-105">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <!-- COLSPAN DIUBAH MENJADI 5 KARENA KOLOM KATEGORI DIHAPUS -->
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="h-16 w-16 rounded-xl bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-900">Tidak ada produk</p>
                                    <p class="text-sm text-gray-500 mt-1">Mulai dengan menambahkan produk pertama Anda</p>
                                </div>
                                <a href="{{ route('admin.products.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Produk
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.querySelector('.bg-green-50');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        }
    });
</script>
@endpush