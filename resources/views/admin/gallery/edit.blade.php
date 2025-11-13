{{-- resources/views/admin/gallery/edit.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Item Gallery</h1>
                    <p class="mt-2 text-sm text-gray-600">Edit item gallery: {{ $gallery->title }}</p>
                </div>
                <a href="{{ route('admin.gallery.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
            <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Current File Preview -->
                @if($gallery->file_url)
                <div class="mb-8 p-6 bg-gray-50 rounded-2xl">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">File Saat Ini</h3>
                    @if($gallery->type === 'photo')
                        <div class="flex items-center space-x-6">
                            <img src="{{ $gallery->file_url }}" 
                                 alt="{{ $gallery->title }}" 
                                 class="w-32 h-32 object-cover rounded-2xl shadow-sm">
                            <div>
                                <div class="font-medium text-gray-900">{{ $gallery->title }}</div>
                                <div class="text-sm text-gray-500 mt-1">Foto</div>
                                <a href="{{ $gallery->file_url }}" 
                                   target="_blank"
                                   class="inline-flex items-center mt-2 text-sm text-amber-600 hover:text-amber-700">
                                    <i class="fas fa-external-link-alt mr-1"></i>Lihat Full Size
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-6">
                            <div class="w-32 h-32 bg-gray-900 rounded-2xl flex items-center justify-center relative">
                                <i class="fas fa-video text-white text-3xl"></i>
                                <div class="absolute inset-0 bg-black/20 rounded-2xl"></div>
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $gallery->title }}</div>
                                <div class="text-sm text-gray-500 mt-1">Video</div>
                                <a href="{{ $gallery->file_url }}" 
                                   target="_blank"
                                   class="inline-flex items-center mt-2 text-sm text-amber-600 hover:text-amber-700">
                                    <i class="fas fa-external-link-alt mr-1"></i>Lihat Video
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                @endif

                <!-- Type Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-4">Jenis Konten</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex cursor-pointer">
                            <input type="radio" name="type" value="photo" class="sr-only peer" 
                                   {{ old('type', $gallery->type) === 'photo' ? 'checked' : '' }}>
                            <div class="flex items-center justify-center w-full p-6 border-2 border-gray-200 rounded-2xl peer-checked:border-amber-500 peer-checked:bg-amber-50 transition-all duration-200 hover:border-gray-300">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mr-4">
                                        <i class="fas fa-image text-amber-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">Foto</div>
                                        <div class="text-sm text-gray-600">Upload gambar JPEG, PNG, JPG</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="relative flex cursor-pointer">
                            <input type="radio" name="type" value="video" class="sr-only peer"
                                   {{ old('type', $gallery->type) === 'video' ? 'checked' : '' }}>
                            <div class="flex items-center justify-center w-full p-6 border-2 border-gray-200 rounded-2xl peer-checked:border-amber-500 peer-checked:bg-amber-50 transition-all duration-200 hover:border-gray-300">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mr-4">
                                        <i class="fas fa-video text-amber-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-900">Video</div>
                                        <div class="text-sm text-gray-600">Upload video MP4, AVI, MOV</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Basic Information -->
                <div class="grid grid-cols-1 gap-6 mb-8">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-3">
                            Judul <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title"
                               value="{{ old('title', $gallery->title) }}"
                               required
                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200"
                               placeholder="Contoh: Proses Panen Madu Tradisional">
                        @error('title')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-3">
                            Deskripsi
                        </label>
                        <textarea name="description" 
                                  id="description"
                                  rows="3"
                                  class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200"
                                  placeholder="Deskripsi singkat tentang konten...">{{ old('description', $gallery->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- File Upload (Optional for edit) -->
                <div class="mb-8">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-3">
                        Ganti File (Opsional)
                    </label>
                    
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-gray-400 transition-colors duration-200"
                         id="upload-area">
                        <div class="space-y-1 text-center" id="upload-content">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-4"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="file" class="relative cursor-pointer bg-white rounded-md font-medium text-amber-600 hover:text-amber-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-amber-500">
                                    <span>Upload file baru</span>
                                    <input id="file" name="file" type="file" class="sr-only" accept=".jpg,.jpeg,.png,.gif,.mp4,.avi,.mov">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500" id="file-types">
                                PNG, JPG, GIF hingga 10MB (Foto) atau MP4, AVI, MOV hingga 10MB (Video)
                            </p>
                            <div id="file-preview" class="hidden mt-4"></div>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti file</p>
                    @error('file')
                        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Settings -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-3">
                            Urutan Tampilan
                        </label>
                        <input type="number" 
                               name="order" 
                               id="order"
                               value="{{ old('order', $gallery->order) }}"
                               min="0"
                               class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                        <p class="mt-2 text-xs text-gray-500">Angka lebih kecil akan ditampilkan lebih awal</p>
                    </div>

                    <div class="flex items-center pt-8">
                        <div class="flex items-center h-5">
                            <input type="checkbox" 
                                   name="is_active" 
                                   id="is_active"
                                   value="1"
                                   {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500">
                        </div>
                        <label for="is_active" class="ml-3 text-sm text-gray-700">
                            Tampilkan di halaman publik
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-3 justify-end pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.gallery.index') }}"
                       class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                        <i class="fas fa-save mr-2"></i>Update Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include the same JavaScript as create view -->
<script>
// Same JavaScript as create.blade.php
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const uploadArea = document.getElementById('upload-area');
    const uploadContent = document.getElementById('upload-content');
    const filePreview = document.getElementById('file-preview');
    const fileTypes = document.getElementById('file-types');
    const typeRadios = document.querySelectorAll('input[name="type"]');

    // Update accepted file types based on selected type
    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'photo') {
                fileInput.setAttribute('accept', '.jpg,.jpeg,.png,.gif');
                fileTypes.textContent = 'PNG, JPG, GIF hingga 10MB';
            } else {
                fileInput.setAttribute('accept', '.mp4,.avi,.mov');
                fileTypes.textContent = 'MP4, AVI, MOV hingga 10MB';
            }
            // Reset file input and preview when type changes
            fileInput.value = '';
            filePreview.classList.add('hidden');
            uploadContent.classList.remove('hidden');
        });
    });

    // File upload preview
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            uploadContent.classList.add('hidden');
            filePreview.classList.remove('hidden');
            
            const fileType = file.type.split('/')[0];
            const fileName = file.name;
            const fileSize = (file.size / (1024 * 1024)).toFixed(2);
            
            if (fileType === 'image') {
                const reader = new FileReader();
                reader.onload = function(e) {
                    filePreview.innerHTML = `
                        <div class="flex items-center space-x-4">
                            <img src="${e.target.result}" alt="Preview" class="w-20 h-20 object-cover rounded-lg">
                            <div class="text-left">
                                <div class="font-medium text-gray-900">${fileName}</div>
                                <div class="text-sm text-gray-500">${fileSize} MB</div>
                                <div class="text-xs text-amber-600 mt-1">Klik untuk mengganti file</div>
                            </div>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            } else if (fileType === 'video') {
                filePreview.innerHTML = `
                    <div class="flex items-center space-x-4">
                        <div class="w-20 h-20 bg-gray-900 rounded-lg flex items-center justify-center">
                            <i class="fas fa-video text-white text-2xl"></i>
                        </div>
                        <div class="text-left">
                            <div class="font-medium text-gray-900">${fileName}</div>
                            <div class="text-sm text-gray-500">${fileSize} MB</div>
                            <div class="text-xs text-amber-600 mt-1">Klik untuk mengganti file</div>
                        </div>
                    </div>
                `;
            }
        }
    });

    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        uploadArea.classList.add('border-amber-500', 'bg-amber-50');
    }

    function unhighlight() {
        uploadArea.classList.remove('border-amber-500', 'bg-amber-50');
    }

    uploadArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        
        // Trigger change event
        const event = new Event('change');
        fileInput.dispatchEvent(event);
    }

    // Click on upload area to trigger file input
    uploadArea.addEventListener('click', function() {
        fileInput.click();
    });
});
</script>
@endsection