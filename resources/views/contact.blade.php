@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 py-20 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmYmJmMjQiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDE2YzAtMi4yMSAxLjc5LTQgNC00czQgMS43OSA0IDQtMS43OSA0LTQgNC00LTEuNzktNC00em0wIDI4YzAtMi4yMSAxLjc5LTQgNC00czQgMS43OSA0IDQtMS43OSA0LTQgNC00LTEuNzktNC00em0tMjAgMGMwLTIuMjEgMS43OS00IDQtNHM0IDEuNzkgNCA0LTEuNzkgNC00IDQtNC0xLjc5LTQtNHptMC0yOGMwLTIuMjEgMS43OS00IDQtNHM0IDEuNzkgNCA0LTEuNzkgNC00IDQtNC0xLzc5LTQtNHoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-40"></div>
    <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
        <div class="inline-block mb-4 px-4 py-2 bg-white/70 backdrop-blur-sm rounded-full text-amber-700 font-medium text-sm shadow-sm">
            Hubungi Kami
        </div>
        <h1 class="text-5xl md:text-6xl font-bold bg-gradient-to-r from-amber-600 via-yellow-600 to-orange-600 bg-clip-text text-transparent mb-6">
            Mari Terhubung
        </h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
            Kami siap membantu Anda. Hubungi kami untuk informasi produk, pemesanan, atau pertanyaan lainnya.
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Information -->
            <div class="lg:col-span-1 space-y-6">
                <div class="sticky top-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Informasi Kontak</h2>
                    
                    <div class="space-y-4">
                        <!-- Address -->
                        <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-amber-200">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-gradient-to-br from-amber-100 to-orange-100 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-map-marker-alt text-amber-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 mb-2">Alamat</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Jl. Tribrata, Ipilo, 
                                        Kec. Kota Timur, <br>
                                        Kota Gorontalo, Gorontalo
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-amber-200">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-gradient-to-br from-green-100 to-emerald-100 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-phone text-green-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 mb-2">Telepon</h3>
                                    <div class="space-y-1">
                                        <a href="tel:+6281234567890" class="block text-gray-600 hover:text-amber-600 transition text-sm font-medium">
                                            +62 823-9620-0375
                                        </a>
                                        <a href="tel:+6289876543210" class="block text-gray-600 hover:text-amber-600 transition text-sm font-medium">
                                            +62 856-9679-8342
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-amber-200">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-gradient-to-br from-blue-100 to-cyan-100 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-envelope text-blue-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 mb-2">Email</h3>
                                    <div class="space-y-1">
                                        <a href="mailto:info@madusuwawa.com" class="block text-gray-600 hover:text-amber-600 transition text-sm font-medium">
                                            madusuwawa@gmail.com
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Business Hours -->
                        <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-amber-200">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-gradient-to-br from-purple-100 to-pink-100 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 mb-2">Jam Operasional</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Senin - Sabtu : 09.00 - 19.00 WITA<br>
                                        Minggu: Tutup<br>
                                        
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-100">
                            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-share-alt text-amber-600"></i>
                                Media Sosial
                            </h3>
                            <div class="flex gap-3">
                                <a href="https://www.facebook.com/share/17N2RcZf4n/" class="group flex-1 bg-white p-3 rounded-xl text-gray-600 hover:bg-blue-600 hover:text-white transition-all duration-300 text-center shadow-sm hover:shadow-md hover:-translate-y-1">
                                    <i class="fab fa-facebook-f text-lg"></i>
                                </a>
                                <a href="https://www.instagram.com/madusuwawa?igsh=d25ia3lnbXIyMmFx" class="group flex-1 bg-white p-3 rounded-xl text-gray-600 hover:bg-pink-600 hover:text-white transition-all duration-300 text-center shadow-sm hover:shadow-md hover:-translate-y-1">
                                    <i class="fab fa-instagram text-lg"></i>
                                </a>
                                <a href="https://www.tiktok.com/@sehat_1.com?_r=1&_t=ZS-91QLOBeNmQJ" class="group flex-1 bg-white p-3 rounded-xl text-gray-600 hover:bg-gray-900 hover:text-white transition-all duration-300 text-center shadow-sm hover:shadow-md hover:-translate-y-1">
                                    <i class="fab fa-tiktok text-lg"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl p-8 md:p-10 shadow-xl border border-gray-100">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Keluhan & Masukan</h2>
                        <p class="text-gray-600">Sampaikan keluhan, kritik, atau saran Anda untuk perbaikan layanan kami</p>
                    </div>
                    
                    <form action="{{ route('contact.submit') }}" method="POST" id="contact-form" class="space-y-6">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Name -->
        <div class="group">
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                id="name" 
                name="name"
                required
                class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 focus:bg-white transition-all duration-300 outline-none"
                placeholder="Masukkan nama lengkap"
                value="{{ old('name') }}">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="group">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                Email <span class="text-red-500">*</span>
            </label>
            <input 
                type="email" 
                id="email" 
                name="email"
                required
                class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 focus:bg-white transition-all duration-300 outline-none"
                placeholder="nama@email.com"
                value="{{ old('email') }}">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Phone -->
    <div class="group">
        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
            Nomor Telepon
        </label>
        <input 
            type="tel" 
            id="phone" 
            name="phone"
            class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 focus:bg-white transition-all duration-300 outline-none"
            placeholder="+62 812-3456-7890"
            value="{{ old('phone') }}">
        @error('phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Subject -->
    <div class="group">
        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">
            Jenis Masukan <span class="text-red-500">*</span>
        </label>
        <select 
            id="subject" 
            name="subject"
            required
            class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 focus:bg-white transition-all duration-300 outline-none appearance-none bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHZpZXdCb3g9IjAgMCAxNiAxNiIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNCw2TDgsMTBMMTIsNiIgc3Ryb2tlPSIjOTk5IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIvPjwvc3ZnPg==')] bg-no-repeat bg-[center_right_1rem]">
            <option value="">Pilih jenis masukan</option>
            <option value="keluhan" {{ old('subject') == 'keluhan' ? 'selected' : '' }}>Keluhan Produk</option>
            <option value="pelayanan" {{ old('subject') == 'pelayanan' ? 'selected' : '' }}>Keluhan Pelayanan</option>
            <option value="saran" {{ old('subject') == 'saran' ? 'selected' : '' }}>Saran Perbaikan</option>
            <option value="kritik" {{ old('subject') == 'kritik' ? 'selected' : '' }}>Kritik Konstruktif</option>
            <option value="pujian" {{ old('subject') == 'pujian' ? 'selected' : '' }}>Pujian & Apresiasi</option>
            <option value="lainnya" {{ old('subject') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
        @error('subject')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Message -->
    <div class="group">
        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
            Detail Keluhan/Masukan <span class="text-red-500">*</span>
        </label>
        <textarea 
            id="message" 
            name="message"
            rows="6"
            required
            class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-amber-500/10 focus:border-amber-500 focus:bg-white transition-all duration-300 outline-none resize-none"
            placeholder="Jelaskan keluhan, kritik, atau saran Anda secara detail...">{{ old('message') }}</textarea>
        @error('message')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <button 
        type="submit"
        class="group w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white py-4 px-6 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-3 hover:-translate-y-0.5">
        <i class="fas fa-paper-plane group-hover:translate-x-1 transition-transform duration-300"></i>
        <span>Kirim Keluhan & Masukan</span>
    </button>
</form>

                    <!-- Success Message -->
                    <div id="success-message" class="hidden mt-6 p-5 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 text-green-800 rounded-xl shadow-sm animate-fade-in">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 bg-green-500 text-white p-2 rounded-lg">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <h4 class="font-bold mb-1">Masukan Terkirim!</h4>
                                <p class="text-sm">Terima kasih atas keluhan dan masukan Anda. Kami akan menindaklanjuti dalam 1x24 jam.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <div class="inline-block mb-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 font-medium text-sm">
                Lokasi
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Kunjungi Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan lokasi kami dan datang langsung untuk pengalaman terbaik</p>
        </div>
        
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            <!-- Google Maps Embed -->
            <div class="relative h-96 overflow-hidden">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d249.35285759975096!2d123.06330396764739!3d0.5329438503564721!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32792b780460c259%3A0x1b2f118222ef6fa6!2sPT.%20Madu%20Suwawa%20Gorontalo!5e0!3m2!1sen!2sid!4v1762269274786!5m2!1sen!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="absolute inset-0">
                </iframe>
                
                <!-- Overlay with Info -->
                <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm rounded-2xl p-4 shadow-lg max-w-xs">
                    <h3 class="font-bold text-gray-900 mb-1">Madu Suwawa</h3>
                    <p class="text-sm text-gray-600 mb-2">Jl. Raya Suwawa No. 123</p>
                    <a href="https://maps.app.goo.gl/ebq8fAxwNSDtHARn7" 
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-amber-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-amber-600 transition-colors">
                        <i class="fas fa-directions"></i>
                        Buka di Maps
                    </a>
                </div>
            </div>
            
            <!-- Map Info -->
            <div class="p-8 md:p-10 bg-gradient-to-br from-gray-50 to-white">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 text-center">
                        <div class="inline-block bg-gradient-to-br from-blue-100 to-cyan-100 p-4 rounded-xl mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-road text-2xl text-blue-600"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Akses Mudah</h4>
                        <p class="text-sm text-gray-600">Lokasi strategis dengan akses jalan yang mudah dijangkau</p>
                    </div>
                    <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 text-center">
                        <div class="inline-block bg-gradient-to-br from-amber-100 to-orange-100 p-4 rounded-xl mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-industry text-2xl text-amber-600"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Area Produksi</h4>
                        <p class="text-sm text-gray-600">Fasilitas produksi modern dengan standar kebersihan tinggi</p>
                    </div>
                    <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 text-center">
                        <div class="inline-block bg-gradient-to-br from-green-100 to-emerald-100 p-4 rounded-xl mb-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-store text-2xl text-green-600"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Banyak Cabang</h4>
                        <p class="text-sm text-gray-600">Tersedia di berbagai cabang untuk memudahkan pelanggan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Distributors Section -->
<section class="py-20 bg-gradient-to-b from-white to-amber-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <div class="inline-block mb-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 font-medium text-sm">
                Distributor
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Distributor Madu Suwawa</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan distributor resmi Madu Suwawa di berbagai daerah untuk kemudahan pembelian</p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Gorontalo Kota -->
            <div class="border-b border-gray-100 last:border-b-0">
                <button class="distributor-toggle w-full px-8 py-6 text-left bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 transition-all duration-300 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Gorontalo</h3>
                        <p class="text-gray-600 text-sm">Kota Gorontalo</p>
                    </div>
                    <div class="flex-shrink-0 bg-amber-500 text-white p-2 rounded-lg">
                        <i class="fas fa-chevron-down transition-transform duration-300"></i>
                    </div>
                </button>
                <div class="distributor-content px-8 pb-6 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Rumah Terapi Gorontalo</h4>
                            <p class="text-gray-600 text-sm mb-2">Jl Taman Surya</p>
                            <a href="tel:+6281393013465" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 813-9301-3465
                            </a>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Pustakah Sunnah</h4>
                            <a href="tel:+6285298111424" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 852-9811-1424
                            </a>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Lapak Azwa/Azwaexpress</h4>
                            <p class="text-gray-600 text-sm mb-2">Jl Poigar</p>
                            <a href="tel:+6282290571023" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 822-9057-1023
                            </a>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Rumah Dinas Imigrasi Gorontalo</h4>
                            <a href="tel:+6281356070019" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 813-5607-0019
                            </a>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Bele Li Umi Afwan</h4>
                            <a href="tel:+6281356668824" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 813-5666-8824
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kabupaten Gorontalo -->
            <div class="border-b border-gray-100 last:border-b-0">
                <button class="distributor-toggle w-full px-8 py-6 text-left bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 transition-all duration-300 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Kabupaten Gorontalo</h3>
                        <p class="text-gray-600 text-sm">Telaga & Telaga Biru</p>
                    </div>
                    <div class="flex-shrink-0 bg-amber-500 text-white p-2 rounded-lg">
                        <i class="fas fa-chevron-down transition-transform duration-300"></i>
                    </div>
                </button>
                <div class="distributor-content px-8 pb-6 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Distributor Madu Suwawa</h4>
                            <p class="text-gray-600 text-sm mb-2">Jl. Ahmad A. Wahab, samping Ice Cream Xiyue, TELAGA</p>
                            <a href="tel:+6285255388228" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 852-5538-8228
                            </a>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Al Barokah Outlet</h4>
                            <p class="text-gray-600 text-sm mb-2">Pentadio Timur, Telaga Biru</p>
                            <a href="tel:+6282190215275" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 821-9021-5275
                            </a>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">MHIJRAH TOKO KURMA, MADU & HERBAL</h4>
                            <a href="tel:+6285395653396" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 853-9565-3396
                            </a>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">SARANG HERBAL 1SIMU</h4>
                            <a href="tel:+6282188760094" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 821-8876-0094
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boalemo -->
            <div class="border-b border-gray-100 last:border-b-0">
                <button class="distributor-toggle w-full px-8 py-6 text-left bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 transition-all duration-300 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Boalemo</h3>
                        <p class="text-gray-600 text-sm">Tilamuta</p>
                    </div>
                    <div class="flex-shrink-0 bg-amber-500 text-white p-2 rounded-lg">
                        <i class="fas fa-chevron-down transition-transform duration-300"></i>
                    </div>
                </button>
                <div class="distributor-content px-8 pb-6 hidden">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Distributor Madu Suwawa</h4>
                            <p class="text-gray-600 text-sm mb-2">Desa Limbato, Jln. Ahmad Yani Kecamatan Tilamuta, 200M dari Kantor Bupati Boalemo</p>
                            <a href="tel:+6282156730354" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 821-5673-0354
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bone Bolango -->
            <div class="border-b border-gray-100 last:border-b-0">
                <button class="distributor-toggle w-full px-8 py-6 text-left bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 transition-all duration-300 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Bone Bolango</h3>
                        <p class="text-gray-600 text-sm">Suwawa & Tapa</p>
                    </div>
                    <div class="flex-shrink-0 bg-amber-500 text-white p-2 rounded-lg">
                        <i class="fas fa-chevron-down transition-transform duration-300"></i>
                    </div>
                </button>
                <div class="distributor-content px-8 pb-6 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Alsin Mart</h4>
                            <a href="tel:+6281242693084" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 812-4269-3084
                            </a>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Belle Li Lidya Ayu</h4>
                            <p class="text-gray-600 text-sm mb-2">Jl KH Abas Rauf Samping Ktr Desa Toluwaya Kompleks Rumah Adat Gobel Tapa</p>
                            <a href="tel:+6285298801649" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 852-9880-1649
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kotamobagu -->
            <div class="border-b border-gray-100 last:border-b-0">
                <button class="distributor-toggle w-full px-8 py-6 text-left bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 transition-all duration-300 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Kotamobagu</h3>
                    </div>
                    <div class="flex-shrink-0 bg-amber-500 text-white p-2 rounded-lg">
                        <i class="fas fa-chevron-down transition-transform duration-300"></i>
                    </div>
                </button>
                <div class="distributor-content px-8 pb-6 hidden">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">Toko Hawwaril Herbal KTG</h4>
                            <a href="tel:+6285657229375" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 856-5722-9375
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Makassar -->
            <div class="border-b border-gray-100 last:border-b-0">
                <button class="distributor-toggle w-full px-8 py-6 text-left bg-gradient-to-r from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 transition-all duration-300 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">Makassar</h3>
                    </div>
                    <div class="flex-shrink-0 bg-amber-500 text-white p-2 rounded-lg">
                        <i class="fas fa-chevron-down transition-transform duration-300"></i>
                    </div>
                </button>
                <div class="distributor-content px-8 pb-6 hidden">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                            <h4 class="font-bold text-gray-900 mb-2">MY ZO (Handmade Bag)</h4>
                            <a href="tel:+62895341302149" class="text-amber-600 hover:text-amber-700 font-medium text-sm">
                                <i class="fas fa-phone mr-2"></i>+62 895-3413-02149
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact Form Handler
    const contactForm = document.getElementById('contact-form');
    const successMessage = document.getElementById('success-message');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            submitBtn.disabled = true;
            
            // Submit form normally (not using AJAX)
            contactForm.submit();
        });
    }

    // FAQ Accordion
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            // Toggle answer
            answer.classList.toggle('hidden');
            
            // Rotate icon
            if (icon.style.transform === 'rotate(180deg)') {
                icon.style.transform = 'rotate(0deg)';
            } else {
                icon.style.transform = 'rotate(180deg)';
            }
            
            // Close other answers
            faqQuestions.forEach(otherQuestion => {
                if (otherQuestion !== this) {
                    const otherAnswer = otherQuestion.nextElementSibling;
                    const otherIcon = otherQuestion.querySelector('i');
                    otherAnswer.classList.add('hidden');
                    otherIcon.style.transform = 'rotate(0deg)';
                }
            });
        });
    });

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('62')) {
                value = '+62 ' + value.substring(2);
            } else if (value.startsWith('0')) {
                value = '+62 ' + value.substring(1);
            }
            e.target.value = value;
        });
    }

    // Distributor Toggle
const distributorToggles = document.querySelectorAll('.distributor-toggle');

distributorToggles.forEach(toggle => {
    toggle.addEventListener('click', function() {
        const content = this.nextElementSibling;
        const icon = this.querySelector('i');
        
        // Toggle content
        content.classList.toggle('hidden');
        
        // Rotate icon
        if (icon.style.transform === 'rotate(180deg)') {
            icon.style.transform = 'rotate(0deg)';
        } else {
            icon.style.transform = 'rotate(180deg)';
        }
    });
});
});
</script>
@endsection