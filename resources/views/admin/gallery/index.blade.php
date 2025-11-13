{{-- resources/views/admin/gallery/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50/30 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Kelola Gallery</h1>
                    <p class="mt-2 text-sm text-gray-600">Kelola foto dan video gallery</p>
                </div>
                <a href="{{ route('admin.gallery.create') }}"
                   class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i>Tambah Item
                </a>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-emerald-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Photos Section -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-image mr-3 text-amber-500"></i>Foto Gallery
                    <span class="ml-3 bg-gray-100 text-gray-700 py-1 px-3 rounded-full text-sm">{{ $photos->count() }}</span>
                </h2>
            </div>

            @if($photos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($photos as $photo)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="relative aspect-square">
                            <img src="{{ Storage::url($photo->file_path) }}" 
                                 alt="{{ $photo->title }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2">
                                @if($photo->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <i class="fas fa-check mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-pause mr-1"></i>Nonaktif
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-900 mb-1">{{ $photo->title }}</h3>
                            @if($photo->description)
                                <p class="text-sm text-gray-500 mb-2">{{ $photo->description }}</p>
                            @endif
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                <span>Urutan: {{ $photo->order }}</span>
                                <span>{{ $photo->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.gallery.edit', $photo) }}"
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                                    <i class="fas fa-edit mr-2"></i>Edit
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $photo) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus foto ini?')"
                                            class="w-full inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-rose-600 hover:bg-rose-700">
                                        <i class="fas fa-trash mr-2"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
                    <i class="fas fa-image text-gray-300 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada foto</h3>
                    <p class="text-gray-500 mb-4">Tambahkan foto pertama Anda ke gallery</p>
                    <a href="{{ route('admin.gallery.create') }}?type=photo"
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-amber-600 hover:bg-amber-700">
                        <i class="fas fa-plus mr-2"></i>Tambah Foto
                    </a>
                </div>
            @endif
        </div>

        <!-- Videos Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-video mr-3 text-amber-500"></i>Video Gallery
                    <span class="ml-3 bg-gray-100 text-gray-700 py-1 px-3 rounded-full text-sm">{{ $videos->count() }}</span>
                </h2>
            </div>

            @if($videos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($videos as $video)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="relative aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <i class="fas fa-video text-gray-400 text-5xl"></i>
                            <div class="absolute top-2 right-2">
                                @if($video->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <i class="fas fa-check mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-pause mr-1"></i>Nonaktif
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium text-gray-900 mb-1">{{ $video->title }}</h3>
                            @if($video->description)
                                <p class="text-sm text-gray-500 mb-2">{{ $video->description }}</p>
                            @endif
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                <span>Urutan: {{ $video->order }}</span>
                                <span>{{ $video->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.gallery.edit', $video) }}"
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                                    <i class="fas fa-edit mr-2"></i>Edit
                                </a>
                                <form action="{{ route('admin.gallery.destroy', $video) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus video ini?')"
                                            class="w-full inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-rose-600 hover:bg-rose-700">
                                        <i class="fas fa-trash mr-2"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
                    <i class="fas fa-video text-gray-300 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada video</h3>
                    <p class="text-gray-500 mb-4">Tambahkan video pertama Anda ke gallery</p>
                    <a href="{{ route('admin.gallery.create') }}?type=video"
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-amber-600 hover:bg-amber-700">
                        <i class="fas fa-plus mr-2"></i>Tambah Video
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection