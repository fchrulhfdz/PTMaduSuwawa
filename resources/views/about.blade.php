@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmYmJmMjQiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDE2YzAtMi4yMSAxLjc5LTQgNC00czQgMS43OSA0IDQtMS43OSA0LTQgNC00LTEuNzktNC00em0wIDI4YzAtMi4yMSAxLzc5LTQgNC00czQgMS43OSA0IDQtMS43OSA0LTQgNC00LTEuNzktNC00em0tMjAgMGMwLTIuMjEgMS43OS00IDQtNHM0IDEuNzkgNCA0LTEuNzkgNC00IDQtNC0xLjc5LTQtNHptMC0yOGMwLTIuMjEgMS43OS00IDQtNHM0IDEuNzkgNCA0LTEuNzkgNC00IDQtNC0xLjc5LTQtNHoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-40"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-20 left-10 w-32 h-32 bg-amber-200/30 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 bg-yellow-200/30 rounded-full blur-3xl"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 text-center z-10">
        <div class="inline-block mb-6 px-6 py-3 bg-white/80 backdrop-blur-sm rounded-full text-amber-700 font-semibold text-sm shadow-lg">
            Tentang Kami
        </div>
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold bg-gradient-to-r from-amber-600 via-yellow-600 to-orange-600 bg-clip-text text-transparent mb-6">
            Madu Suwawa
        </h1>
        <p class="text-xl md:text-2xl text-gray-700 max-w-3xl mx-auto leading-relaxed">
            Menghadirkan keaslian dan kualitas madu terbaik dari jantung alam Suwawa sejak 2010
        </p>
    </div>
</section>

<!-- Story Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="inline-block mb-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 font-medium text-sm">
                    Cerita Kami
                </div>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Perjalanan Kami</h2>
                <div class="space-y-6 text-gray-600 text-lg leading-relaxed">
    <p>
        Madu Suwawa merupakan produk madu asli yang berasal dari kawasan Suwawa, Bone Bolango, Gorontalo. Madu ini dihasilkan dari nektar bunga-bunga alami di hutan Suwawa yang dikenal memiliki keanekaragaman hayati yang tinggi.
    </p>
    <p>
        Sejak berdiri, Madu Suwawa berkomitmen untuk memproduksi madu murni 100% tanpa campuran gula atau bahan kimia. Proses produksi dilakukan secara tradisional dengan menjaga kearifan lokal dan kelestarian lingkungan.
    </p>
    <p>
        Madu Suwawa memiliki karakteristik khusus dengan warna yang lebih gelap, aroma yang harum, dan rasa yang manis alami. Kandungan nutrisinya yang lengkap membuat madu ini memiliki berbagai khasiat untuk kesehatan dan daya tahan tubuh.
    </p>
    <p>
        Keunggulan Madu Suwawa terletak pada proses panen yang berkelanjutan, dimana lebah madu dibiarkan hidup secara alami di habitat aslinya tanpa menggunakan bahan kimia atau antibiotik yang dapat merusak kualitas madu.
    </p>
    <p>
        Saat ini Madu Suwawa telah berkembang menjadi salah satu produk unggulan daerah Gorontalo yang tidak hanya dikonsumsi lokal tetapi juga telah sampai ke berbagai wilayah di Indonesia, membawa khasiat madu asli dari bumi Suwawa.
    </p>
</div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mt-10">
                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="text-4xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent mb-2">14+</div>
                            <div class="text-gray-600 font-medium text-sm">Tahun Pengalaman</div>
                        </div>
                    </div>
                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-yellow-100 to-amber-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="text-4xl font-bold bg-gradient-to-r from-yellow-600 to-amber-600 bg-clip-text text-transparent mb-2">500+</div>
                            <div class="text-gray-600 font-medium text-sm">Petani Mitra</div>
                        </div>
                    </div>
                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">50K+</div>
                            <div class="text-gray-600 font-medium text-sm">Pelanggan Puas</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative">
    <div class="relative z-10">
        <div class="bg-gradient-to-br from-amber-200 to-orange-200 rounded-3xl p-2 shadow-2xl">
            <img src="{{ asset('storage/logo/logo madu suwawa.jpg') }}" 
                alt="Logo Madu Suwawa" 
                class="w-full h-96 object-cover rounded-2xl">
        </div>
    </div>
    <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-gradient-to-br from-amber-200 to-orange-200 rounded-3xl blur-2xl opacity-50 z-0"></div>
    <div class="absolute -top-8 -left-8 w-32 h-32 bg-gradient-to-br from-yellow-200 to-amber-200 rounded-full blur-2xl opacity-50 z-0"></div>
</div>
        </div>
    </div>
</section>

<!-- Vision Mission Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Vision -->
            <div class="group relative bg-white rounded-3xl p-10 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-100 to-transparent rounded-bl-full opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-amber-100 to-orange-100 p-4 rounded-2xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-eye text-3xl text-amber-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">Visi Kami</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Menjadi produsen madu asli Suwawa terdepan yang diakui secara nasional dalam melestarikan kearifan lokal dan menghadirkan madu berkualitas premium untuk kesehatan masyarakat Indonesia.
                    </p>
                </div>
            </div>

            <!-- Mission -->
            <div class="group relative bg-white rounded-3xl p-10 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-100 to-transparent rounded-bl-full opacity-50"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-orange-100 to-red-100 p-4 rounded-2xl mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-bullseye text-3xl text-orange-600"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">Misi Kami</h3>
                    </div>
                    <ul class="space-y-4 text-gray-600 text-lg">
                        <li class="flex items-start group/item">
                            <div class="flex-shrink-0 bg-gradient-to-br from-amber-100 to-orange-100 p-2 rounded-lg mr-3 group-hover/item:scale-110 transition-transform duration-300">
                                <i class="fas fa-check text-amber-600"></i>
                            </div>
                            <span>Memproduksi madu asli 100% tanpa campuran dengan standar higienis yang ketat</span>
                        </li>
                        <li class="flex items-start group/item">
                            <div class="flex-shrink-0 bg-gradient-to-br from-amber-100 to-orange-100 p-2 rounded-lg mr-3 group-hover/item:scale-110 transition-transform duration-300">
                                <i class="fas fa-check text-amber-600"></i>
                            </div>
                            <span>Meningkatkan kesejahteraan petani madu lokal melalui sistem kemitraan yang berkelanjutan</span>
                        </li>
                        <li class="flex items-start group/item">
                            <div class="flex-shrink-0 bg-gradient-to-br from-amber-100 to-orange-100 p-2 rounded-lg mr-3 group-hover/item:scale-110 transition-transform duration-300">
                                <i class="fas fa-check text-amber-600"></i>
                            </div>
                            <span>Melestarikan lingkungan dan ekosistem lebah madu di kawasan hutan Suwawa</span>
                        </li>
                        <li class="flex items-start group/item">
                            <div class="flex-shrink-0 bg-gradient-to-br from-amber-100 to-orange-100 p-2 rounded-lg mr-3 group-hover/item:scale-110 transition-transform duration-300">
                                <i class="fas fa-check text-amber-600"></i>
                            </div>
                            <span>Mengedukasi masyarakat tentang manfaat madu asli dan budidaya lebah yang ramah lingkungan</span>
                        </li>
                        <li class="flex items-start group/item">
                            <div class="flex-shrink-0 bg-gradient-to-br from-amber-100 to-orange-100 p-2 rounded-lg mr-3 group-hover/item:scale-110 transition-transform duration-300">
                                <i class="fas fa-check text-amber-600"></i>
                            </div>
                            <span>Mengembangkan produk turunan madu yang inovatif untuk memenuhi kebutuhan pasar</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-20 bg-gradient-to-b from-white to-amber-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 mb-4 px-6 py-3 bg-gradient-to-r from-amber-100 to-orange-100 rounded-full text-amber-700 font-semibold text-sm shadow-sm">
                <i class="fas fa-images text-amber-600"></i>
                <span>Gallery Kami</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent mb-4">
                Jejak Keberkahan Madu Suwawa
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto leading-relaxed">
                Dokumentasi perjalanan madu asli dari hutan Suwawa hingga sampai ke tangan Anda
            </p>
        </div>

        <!-- Photo Gallery -->
<div class="mb-16">
    <h3 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-4 text-center">
    Foto Dokumentasi
</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $galleryPhotos = \App\Models\Gallery::activePhotos()->limit(4)->get();
        @endphp

        @forelse($galleryPhotos as $index => $photo)
        <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
            <div class="aspect-square overflow-hidden bg-gray-200">
                <img src="{{ asset('storage/' . $photo->file_path)}}" 
                     alt="{{ $photo->title }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
            </div>
        </div>
        @empty
        <!-- Fallback jika tidak ada foto di database -->
        @for($i = 1; $i <= 4; $i++)
        <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
            <div class="aspect-square overflow-hidden bg-gray-200">
                <img src="https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                     alt="Placeholder {{ $i }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            </div>
        </div>
        @endfor
        @endforelse
    </div>
</div>

<!-- Video Gallery -->
<div class="mb-16">
    <h3 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-4 text-center">
    Video Dokumentasi
</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
        @php
            $galleryVideos = \App\Models\Gallery::activeVideos()->limit(2)->get();
        @endphp

        @forelse($galleryVideos as $video)
        <div class="group relative overflow-hidden rounded-2xl shadow-lg">
            <div class="aspect-video overflow-hidden bg-gray-200">
                <video class="w-full h-full object-cover" controls>
                    <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            </div>
        </div>
        @empty
        @for($i = 1; $i <= 2; $i++)
        <div class="aspect-video overflow-hidden bg-gray-200 flex items-center justify-center rounded-2xl">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-play text-white text-xl"></i>
                </div>
                <p class="text-gray-600 font-medium">Video Dokumentasi {{ $i }}</p>
            </div>
        </div>
        @endfor
        @endforelse
    </div>
</div>

</section>

<!-- Values Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block mb-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 font-medium text-sm">
                Nilai-Nilai Kami
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Komitmen Kami</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Prinsip yang menjadi fondasi dalam setiap produk yang kami hasilkan</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group text-center p-8 bg-gradient-to-br from-white to-amber-50 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:-translate-y-2">
                <div class="relative inline-block mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-200 to-emerald-200 rounded-2xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <div class="relative bg-gradient-to-br from-green-100 to-emerald-100 w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-leaf text-3xl text-green-600"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-900">Keaslian</h3>
                <p class="text-gray-600 leading-relaxed">Kami menjamin 100% madu murni tanpa campuran gula atau bahan kimia lainnya</p>
            </div>
            
            <div class="group text-center p-8 bg-gradient-to-br from-white to-yellow-50 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:-translate-y-2">
                <div class="relative inline-block mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-200 to-yellow-200 rounded-2xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <div class="relative bg-gradient-to-br from-amber-100 to-yellow-100 w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-award text-3xl text-amber-600"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-900">Kualitas</h3>
                <p class="text-gray-600 leading-relaxed">Proses produksi yang higienis dan standar kualitas terbaik untuk setiap produk</p>
            </div>
            
            <div class="group text-center p-8 bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:-translate-y-2">
                <div class="relative inline-block mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-200 to-cyan-200 rounded-2xl blur-xl opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                    <div class="relative bg-gradient-to-br from-blue-100 to-cyan-100 w-20 h-20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-handshake text-3xl text-blue-600"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold mb-4 text-gray-900">Keberlanjutan</h3>
                <p class="text-gray-600 leading-relaxed">Berkolaborasi dengan petani lokal dan menjaga kelestarian lingkungan</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <div class="inline-block mb-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 font-medium text-sm">
                Kolaborasi
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Didukung Oleh</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Kolaborasi dengan petani madu berpengalaman di kawasan Suwawa
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="group text-center">
                <div class="relative mb-6 inline-block">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-200 to-orange-200 rounded-3xl blur-2xl opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                    <div class="relative bg-white rounded-3xl w-32 h-32 flex items-center justify-center mx-auto shadow-xl group-hover:shadow-2xl transition-all duration-300 group-hover:-translate-y-2 border border-gray-100">
                        <i class="fas fa-users text-5xl text-amber-600"></i>
                    </div>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">500+ Petani</h4>
                <p class="text-gray-600 font-medium">Mitra Petani Madu</p>
            </div>

            <div class="group text-center">
                <div class="relative mb-6 inline-block">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-200 to-emerald-200 rounded-3xl blur-2xl opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                    <div class="relative bg-white rounded-3xl w-32 h-32 flex items-center justify-center mx-auto shadow-xl group-hover:shadow-2xl transition-all duration-300 group-hover:-translate-y-2 border border-gray-100">
                        <i class="fas fa-home text-5xl text-green-600"></i>
                    </div>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">15 Desa</h4>
                <p class="text-gray-600 font-medium">Desa Penghasil Madu</p>
            </div>

            <div class="group text-center">
                <div class="relative mb-6 inline-block">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-200 to-cyan-200 rounded-3xl blur-2xl opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                    <div class="relative bg-white rounded-3xl w-32 h-32 flex items-center justify-center mx-auto shadow-xl group-hover:shadow-2xl transition-all duration-300 group-hover:-translate-y-2 border border-gray-100">
                        <i class="fas fa-tree text-5xl text-blue-600"></i>
                    </div>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">1000+ Ha</h4>
                <p class="text-gray-600 font-medium">Kawasan Hutan Lebah</p>
            </div>

            <div class="group text-center">
                <div class="relative mb-6 inline-block">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-200 to-amber-200 rounded-3xl blur-2xl opacity-30 group-hover:opacity-50 transition-opacity duration-300"></div>
                    <div class="relative bg-white rounded-3xl w-32 h-32 flex items-center justify-center mx-auto shadow-xl group-hover:shadow-2xl transition-all duration-300 group-hover:-translate-y-2 border border-gray-100">
                        <i class="fas fa-medal text-5xl text-yellow-600"></i>
                    </div>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-2">Sertifikasi</h4>
                <p class="text-gray-600 font-medium">Halal & Organik</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="relative py-20 bg-gradient-to-br from-amber-600 via-orange-600 to-red-600 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-30"></div>
    
    <!-- Decorative blobs -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 text-center z-10">
        <div class="inline-block mb-6 px-6 py-3 bg-white/20 backdrop-blur-sm rounded-full text-white font-semibold text-sm">
            Mari Berkolaborasi
        </div>
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Tertarik dengan Produk Kami?</h2>
        <p class="text-amber-50 text-xl mb-10 leading-relaxed max-w-2xl mx-auto">
            Dapatkan madu asli Suwawa dengan kualitas terbaik untuk kesehatan keluarga Anda
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('products') }}" 
            class="group bg-white text-amber-600 px-10 py-4 rounded-xl font-bold text-lg hover:bg-amber-50 transition-all duration-300 inline-flex items-center justify-center shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <i class="fas fa-shopping-bag mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Lihat Produk</span>
            </a>
            <a href="{{ route('contact') }}" 
            class="group border-2 border-white text-white px-10 py-4 rounded-xl font-bold text-lg hover:bg-white hover:text-amber-600 transition-all duration-300 inline-flex items-center justify-center shadow-xl hover:shadow-2xl hover:-translate-y-1">
                <i class="fas fa-phone mr-3 group-hover:scale-110 transition-transform duration-300"></i>
                <span>Hubungi Kami</span>
            </a>
        </div>
    </div>
</section>
@endsection