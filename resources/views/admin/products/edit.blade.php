<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Smart Cashier</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-gradient-to-r from-blue-600 to-purple-700 text-white shadow-lg">
            <div class="container mx-auto px-4 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold"><i class="fas fa-cash-register mr-3"></i>Smart Cashier</h1>
                        <p class="text-blue-100">Edit Produk</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm opacity-90">{{ date('d F Y') }}</div>
                        <div id="live-clock" class="text-lg font-mono font-bold"></div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b">
            <div class="container mx-auto px-4">
                <div class="flex space-x-8 py-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.transactions.create') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        <i class="fas fa-plus"></i>
                        <span>Transaksi Baru</span>
                    </a>
                    <a href="{{ route('admin.transactions.index') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">
                        <i class="fas fa-list"></i>
                        <span>Daftar Transaksi</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center space-x-2 px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container mx-auto px-4 py-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center justify-center p-2 bg-white hover:bg-gray-50 text-gray-600 rounded-lg shadow-sm border border-gray-200 transition-all duration-200 hover:scale-105">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Edit Produk</h1>
                        <p class="mt-1 text-sm text-gray-600">Perbarui informasi produk {{ $product->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Product Info Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Product Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                                    <input type="text" 
                                           name="name" 
                                           id="name"
                                           value="{{ old('name', $product->name) }}"
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                    <select name="category" 
                                            id="category"
                                            required
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        <option value="Madu Hutan" {{ $product->category == 'Madu Hutan' ? 'selected' : '' }}>Madu Hutan</option>
                                        <option value="Madu Budidaya" {{ $product->category == 'Madu Budidaya' ? 'selected' : '' }}>Madu Budidaya</option>
                                        <option value="Madu Organik" {{ $product->category == 'Madu Organik' ? 'selected' : '' }}>Madu Organik</option>
                                        <option value="Madu Spesial" {{ $product->category == 'Madu Spesial' ? 'selected' : '' }}>Madu Spesial</option>
                                    </select>
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Price & Stock -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                                        <input type="number" 
                                               name="price" 
                                               id="price"
                                               value="{{ old('price', $product->price) }}"
                                               min="0"
                                               step="1000"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        @error('price')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                                        <input type="number" 
                                               name="stock" 
                                               id="stock"
                                               value="{{ old('stock', $product->stock) }}"
                                               min="0"
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                                        @error('stock')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Image Upload -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Produk</label>
                                    
                                    <!-- Existing Image -->
                                    @if($product->image)
                                    <div id="existingImage" class="mb-4">
                                        <div class="relative inline-block">
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-32 h-32 object-cover rounded-lg border-2 border-blue-200">
                                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-2">Gambar saat ini</p>
                                    </div>
                                    @endif

                                    <!-- Image Preview for New Upload -->
                                    <div id="imagePreview" class="hidden mb-4">
                                        <div class="relative inline-block">
                                            <img id="previewImage" class="w-32 h-32 object-cover rounded-lg border-2 border-blue-200">
                                            <button type="button" id="removeImage" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <p id="fileName" class="text-sm text-gray-600 mt-2"></p>
                                    </div>

                                    <!-- Upload Area -->
                                    <div id="uploadArea" class="flex items-center justify-center w-full">
                                        <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class="fas fa-cloud-upload-alt text-gray-400 text-xl mb-2"></i>
                                                <p class="text-sm text-gray-500">Klik untuk upload gambar baru</p>
                                                <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG (Max 2MB)</p>
                                            </div>
                                            <input id="image" name="image" type="file" class="hidden" accept="image/*">
                                        </label>
                                    </div>
                                    @error('image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.products.index') }}" 
                               class="px-6 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-all duration-200">
                                Batal
                            </a>
                            <button type="submit" 
                                    id="submitBtn"
                                    class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-all duration-200 flex items-center space-x-2">
                                <i class="fas fa-save"></i>
                                <span>Update Produk</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Live Clock
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
            document.getElementById('live-clock').textContent = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');
            const fileName = document.getElementById('fileName');
            const removeImage = document.getElementById('removeImage');
            const uploadArea = document.getElementById('uploadArea');
            const submitBtn = document.getElementById('submitBtn');
            const existingImage = document.getElementById('existingImage');

            // Handle image selection
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                        return;
                    }

                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file maksimal 2MB.');
                        return;
                    }

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        uploadArea.classList.add('hidden');
                        
                        // Hide existing image if new image is uploaded
                        if (existingImage) {
                            existingImage.classList.add('hidden');
                        }
                        
                        // Update file info
                        fileName.textContent = file.name;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove image
            removeImage.addEventListener('click', function() {
                imageInput.value = '';
                imagePreview.classList.add('hidden');
                uploadArea.classList.remove('hidden');
                
                // Show existing image again
                if (existingImage) {
                    existingImage.classList.remove('hidden');
                }
            });
        });
    </script>
</body>
</html>