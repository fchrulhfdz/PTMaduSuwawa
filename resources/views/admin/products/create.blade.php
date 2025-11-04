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
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Tambah Produk Baru</h1>
                    <p class="mt-1 text-sm text-gray-600">Tambahkan produk madu baru ke katalog Anda</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                
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
                                       required
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 placeholder-gray-400"
                                       placeholder="Masukkan nama produk">
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
                                    <option value="">Pilih Kategori</option>
                                    <option value="Madu Hutan">Madu Hutan</option>
                                    <option value="Madu Budidaya">Madu Budidaya</option>
                                    <option value="Madu Organik">Madu Organik</option>
                                    <option value="Madu Spesial">Madu Spesial</option>
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
                                           min="0"
                                           step="1000"
                                           required
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 placeholder-gray-400"
                                           placeholder="0">
                                    @error('price')
                                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="stock" class="block text-sm font-semibold text-gray-900 mb-3">Stok</label>
                                    <input type="number" 
                                           name="stock" 
                                           id="stock"
                                           min="0"
                                           required
                                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 placeholder-gray-400"
                                           placeholder="0">
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
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="hidden mb-4">
                                    <div class="relative inline-block">
                                        <img id="previewImage" class="w-32 h-32 object-cover rounded-2xl border-2 border-amber-200 shadow-sm">
                                        <button type="button" id="removeImage" class="absolute -top-2 -right-2 w-6 h-6 bg-rose-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-rose-600 transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <p id="fileName" class="text-sm text-gray-600 mt-2"></p>
                                </div>

                                <!-- Upload Area -->
                                <div id="uploadArea" class="flex items-center justify-center w-full">
                                    <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-gray-400 text-xl mb-2"></i>
                                            <p class="text-sm text-gray-500">Klik untuk upload gambar</p>
                                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, JPEG (Max 2MB)</p>
                                        </div>
                                        <input id="image" name="image" type="file" class="hidden" accept="image/*">
                                    </label>
                                </div>
                                @error('image')
                                    <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Uploaded Files Table -->
                            <div id="fileTable" class="hidden">
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                    <h4 class="text-sm font-semibold text-gray-900 mb-3">File yang akan diupload</h4>
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-image text-amber-600 text-sm"></i>
                                                </div>
                                                <div>
                                                    <p id="tableFileName" class="text-sm font-medium text-gray-900"></p>
                                                    <p id="fileSize" class="text-xs text-gray-500"></p>
                                                </div>
                                            </div>
                                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-900 mb-3">Deskripsi</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 placeholder-gray-400 resize-none"
                                  placeholder="Deskripsi produk..."></textarea>
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
                                id="submitBtn"
                                class="px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center space-x-2">
                            <i class="fas fa-save"></i>
                            <span>Simpan Produk</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const removeImage = document.getElementById('removeImage');
    const uploadArea = document.getElementById('uploadArea');
    const fileTable = document.getElementById('fileTable');
    const tableFileName = document.getElementById('tableFileName');
    const fileSize = document.getElementById('fileSize');
    const submitBtn = document.getElementById('submitBtn');
    const productForm = document.getElementById('productForm');

    // Handle image selection
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                showNotification('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.', 'error');
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showNotification('Ukuran file maksimal 2MB.', 'error');
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imagePreview.classList.remove('hidden');
                uploadArea.classList.add('hidden');
                
                // Update file info
                fileName.textContent = file.name;
                tableFileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                
                // Show file table
                fileTable.classList.remove('hidden');
                
                // Enable submit button
                submitBtn.disabled = false;
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove image
    removeImage.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.classList.add('hidden');
        uploadArea.classList.remove('hidden');
        fileTable.classList.add('hidden');
        submitBtn.disabled = false;
    });

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Form submission with loading state
    productForm.addEventListener('submit', function(e) {
        const file = imageInput.files[0];
        if (file) {
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Menyimpan...</span>';
        }
    });

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : type === 'warning' ? 'bg-yellow-500' : 'bg-blue-500';
        const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';
        
        notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-xl shadow-lg z-50 transform transition-transform duration-300 translate-x-full`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <i class="fas ${icon} text-lg"></i>
                <span class="font-semibold">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Drag and drop functionality
    const uploadLabel = document.querySelector('label[for="image"]');
    
    uploadLabel.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-amber-400', 'bg-amber-50');
    });
    
    uploadLabel.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('border-amber-400', 'bg-amber-50');
    });
    
    uploadLabel.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-amber-400', 'bg-amber-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            const event = new Event('change', { bubbles: true });
            imageInput.dispatchEvent(event);
        }
    });
});
</script>

<style>
    #uploadArea label {
        transition: all 0.3s ease;
    }
    
    #uploadArea label:hover {
        border-color: rgb(245, 158, 11);
        background-color: rgb(254, 252, 232);
    }
    
    .fa-spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endsection