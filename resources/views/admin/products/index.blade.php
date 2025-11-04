@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manajemen Produk</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola semua produk madu Anda di satu tempat</p>
                </div>
                <a href="{{ route('admin.products.create') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Produk
                </a>
            </div>
        </div>

        <!-- Alert Section -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Products Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50/80 backdrop-blur-sm">
                        <tr>
                            <th class="px-8 py-4 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Produk</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Kategori</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Harga</span>
                            </th>
                            <th class="px-6 py-4 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Stok</span>
                            </th>
                            <th class="px-8 py-4 text-left">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($product->image)
                                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 p-0.5 shadow-inner">
                                                <img class="h-full w-full rounded-xl object-cover" 
                                                     src="{{ asset('storage/' . $product->image) }}" 
                                                     alt="{{ $product->name }}">
                                            </div>
                                        @else
                                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center shadow-inner">
                                                <i class="fas fa-honey-pot text-amber-600 text-lg"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500 truncate mt-1">{{ Str::limit($product->description, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                    {{ $product->category }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center">
                                    <div class="text-sm font-semibold text-gray-900 {{ $product->stock < 10 ? 'text-rose-600' : '' }}">
                                        {{ $product->stock }}
                                    </div>
                                    @if($product->stock < 10)
                                        <i class="fas fa-exclamation-triangle text-rose-400 ml-2 text-sm"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="inline-flex items-center justify-center p-2.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-xl transition-all duration-200 hover:scale-105 hover:shadow-md">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center p-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl transition-all duration-200 hover:scale-105 hover:shadow-md">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <div class="h-16 w-16 rounded-2xl bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-inbox text-gray-400 text-xl"></i>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm font-medium text-gray-900">Tidak ada produk</p>
                                        <p class="text-sm text-gray-500 mt-1">Mulai dengan menambahkan produk pertama Anda</p>
                                    </div>
                                    <a href="{{ route('admin.products.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors duration-200">
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
</div>
@endsection