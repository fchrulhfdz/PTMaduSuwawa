@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.products.index') }}" 
                   class="inline-flex items-center justify-center p-2.5 bg-white hover:bg-gray-50 text-gray-600 rounded-2xl shadow-sm border border-gray-200 transition-all duration-200 hover:scale-105">
                    <i class="fas fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Produk</h1>
                    <p class="mt-1 text-sm text-gray-600">Perbarui informasi produk {{ $product->name }}</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="p-8 space-y-8">
                    <!-- Product Info Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-8">
                            <!-- Product Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-900 mb-3">Nama Produk</label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       value="{{ old('name', $product->name) }}"
                                       required
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 placeholder-gray-400">
                                @error('name')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-semibold text-gray-900 mb-3">Kategori</label>
                                <select name="category" 
                                        id="category"
                                        required
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,<svg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%204%205%22%3E%3Cpath%20fill%3D%22%236B7280%22%20d%3D%22M2%200L0%202h4zm0%205L0%203h4z%22%2F%3E%3C%2Fsvg%3E')] bg-no-repeat bg-right-4 bg-center bg-[length:8px_10px]">
                                    <option value="Madu Hutan" {{ $product->category == 'Madu Hutan' ? 'selected' : '' }}>Madu Hutan</option>
                                    <option value="Madu Budidaya" {{ $product->category == 'Madu Budidaya' ? 'selected' : '' }}>Madu Budidaya</option>
                                    <option value="Madu Organik" {{ $product->category == 'Madu Organik' ? 'selected' : '' }}>Madu Organik</option>
                                    <option value="Madu Spesial" {{ $product->category == 'Madu Spesial' ? 'selected' : '' }}>Madu Spesial</option>
                                </select>
                                @error('category')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price & Stock -->
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="price" class="block text-sm font-semibold text-gray-900 mb-3">Harga (Rp)</label>
                                    <input type="number" 
                                           name="price" 
                                           id="price"
                                           value="{{ old('price', $product->price) }}"
                                           min="0"
                                           step="1000"
                                           required
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 placeholder-gray-400">
                                    @error('price')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="stock" class="block text-sm font-semibold text-gray-900 mb-3">Stok</label>
                                    <input type="number" 
                                           name="stock" 
                                           id="stock"
                                           value="{{ old('stock', $product->stock) }}"
                                           min="0"
                                           required
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 placeholder-gray-400">
                                    @error('stock')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-8">
                            <!-- Image Upload -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-3">Gambar Produk</label>
                                
                                @if($product->image)
                                <div class="mb-4">
                                    <div class="relative inline-block">
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="h-32 w-32 rounded-2xl object-cover shadow-md border border-gray-200">
                                        <div class="absolute -top-2 -right-2 bg-white rounded-full p-1 shadow-lg">
                                            <i class="fas fa-image text-amber-500 text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="flex items-center justify-center w-full">
                                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-xl mb-2"></i>
                                            <p class="text-sm text-gray-500">Klik untuk upload gambar</p>
                                        </div>
                                        <input id="image" name="image" type="file" class="hidden" accept="image/*">
                                    </label>
                                </div>
                                @error('image')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-900 mb-3">Deskripsi</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 placeholder-gray-400 resize-none">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('admin.products.index') }}" 
                           class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-200 transform hover:-translate-y-0.5 shadow-sm hover:shadow-md">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                            Update Produk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection