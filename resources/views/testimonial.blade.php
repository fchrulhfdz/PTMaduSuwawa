@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 bg-gradient-to-br from-amber-50 via-yellow-50 to-orange-50 overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmYmJmMjQiIGZpbGwtb3BhY2l0eT0iMC4wNSI+PHBhdGggZD0iTTM2IDE2YzAtMi4yMSAxLjc5LTQgNC00czQgMS43OSA0IDQtMS43OSA0LTQgNC00LTEuNzktNC00em0wIDI4YzAtMi4yMSAxLjc5LTQgNC00czQgMS43OSA0IDQtMS43OSA0LTQgNC00LTEuNzktNC00em0tMjAgMGMwLTIuMjEgMS43OS00IDQtNHM0IDEuNzkgNCA0LTEuNzkgNC00IDQtNC0xLjc5LTQtNHptMC0yOGMwLTIuMjEgMS43OS00IDQtNHM0IDEuNzkgNCA0LTEuNzkgNC00IDQtNC0xLzc5LTQtNHoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-40"></div>
    
    <div class="absolute bottom-40 left-20 w-20 h-20 bg-gradient-to-br from-yellow-300 to-amber-300 rounded-full blur-2xl opacity-25 flex items-center justify-center">
        <span class="text-white font-bold text-lg">
            @if($testimonials->count() > 3)
                {{ substr($testimonials->skip(3)->first()->customer_name, 0, 1) }}
            @else
                <i class="fas fa-user"></i>
            @endif
        </span>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 text-center z-10">
        <div class="inline-block mb-6 px-6 py-3 bg-white/80 backdrop-blur-sm rounded-full text-amber-700 font-semibold text-sm shadow-lg">
            Testimonial Pelanggan
        </div>
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold bg-gradient-to-r from-amber-600 via-yellow-600 to-orange-600 bg-clip-text text-transparent mb-6">
            Kata Mereka
        </h1>
        <p class="text-xl md:text-2xl text-gray-700 max-w-3xl mx-auto leading-relaxed">
            Dengarkan pengalaman nyata dari pelanggan setia yang telah merasakan khasiat 
            <span class="font-semibold text-amber-600">madu Suwawa asli untuk kesehatan keluarga.</span>
        </p>

        <!-- Trust Indicators -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
            <div class="text-center group">
                <div class="bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent mb-2">{{ $testimonials->count() }}+</div>
                    <div class="text-gray-600 font-medium text-sm">Testimonial</div>
                </div>
            </div>
            <div class="text-center group">
                <div class="bg-gradient-to-br from-yellow-100 to-amber-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-yellow-600 to-amber-600 bg-clip-text text-transparent mb-2">{{ number_format($testimonials->avg('rating') ?? 0, 1) }}/5</div>
                    <div class="text-gray-600 font-medium text-sm">Rating Rata-rata</div>
                </div>
            </div>
            <div class="text-center group">
                <div class="bg-gradient-to-br from-orange-100 to-red-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">{{ $testimonials->where('is_featured', true)->count() }}+</div>
                    <div class="text-gray-600 font-medium text-sm">Featured</div>
                </div>
            </div>
            <div class="text-center group">
                <div class="bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">100%</div>
                    <div class="text-gray-600 font-medium text-sm">Kepuasan</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonial Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <div class="inline-block mb-4 px-4 py-2 bg-amber-100 rounded-full text-amber-700 font-medium text-sm">
                Testimonial Pelanggan
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Apa Kata Pelanggan Kami</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Pengalaman nyata dari pelanggan yang telah merasakan kualitas madu Suwawa asli</p>
        </div>
        
        <!-- Testimonials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $testimonial)
            <div class="group relative bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 overflow-hidden hover:-translate-y-2">
                <!-- Decorative Element -->
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-50 to-transparent rounded-bl-full opacity-60"></div>
                
                <div class="relative z-10">
                    <!-- Customer Info -->
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-400 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                            {{ substr($testimonial->customer_name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900 text-lg">{{ $testimonial->customer_name }}</h4>
                            <p class="text-amber-600 font-medium text-sm">{{ $testimonial->customer_title ?? 'Pelanggan Madu Suwawa' }}</p>
                        </div>
                    </div>
                    
                    <!-- Rating -->
                    <div class="flex mb-6">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-xl {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-gray-300' }} mr-1"></i>
                        @endfor
                        <span class="ml-2 text-sm font-semibold text-gray-600">({{ $testimonial->rating }}/5)</span>
                    </div>
                    
                    <!-- Testimonial Text -->
                    <p class="text-gray-700 leading-relaxed text-lg italic relative">
                        <i class="fas fa-quote-left text-amber-200 text-2xl absolute -left-2 -top-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                        "{{ $testimonial->testimonial }}"
                    </p>

                    <!-- Status Badge -->
                    <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-100">
                        @if($testimonial->is_featured)
                        <span class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg flex items-center">
                            <i class="fas fa-star mr-2"></i>
                            Featured
                        </span>
                        @else
                        <span class="bg-gray-100 text-gray-600 px-4 py-2 rounded-full text-xs font-bold flex items-center">
                            <i class="fas fa-check mr-2"></i>
                            Verified
                        </span>
                        @endif
                        
                        <div class="text-right">
                            <div class="text-xs text-gray-500">Bergabung</div>
                            <div class="text-sm font-semibold text-gray-700">{{ $testimonial->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Decorative Section -->
<section class="relative py-16 bg-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmYmJmMjQiIGZpbGwtb3BhY2l0eT0iMC4wMiI+PGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPjwvZz48L2c+PC9zdmc+')] opacity-20"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-10 left-10 w-24 h-24 bg-gradient-to-br from-amber-200 to-orange-200 rounded-full blur-2xl opacity-30"></div>
    <div class="absolute bottom-10 right-10 w-32 h-32 bg-gradient-to-br from-yellow-200 to-amber-200 rounded-full blur-2xl opacity-30"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-gradient-to-br from-orange-200 to-red-200 rounded-full blur-xl opacity-25"></div>
    <div class="absolute bottom-1/3 right-1/4 w-20 h-20 bg-gradient-to-br from-amber-200 to-yellow-200 rounded-full blur-xl opacity-25"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 text-center z-10">
        <!-- Quote Icon -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl shadow-lg">
                <i class="fas fa-quote-right text-3xl text-amber-600"></i>
            </div>
        </div>
        
        <!-- Inspirational Quote -->
        <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 leading-relaxed">
            "Setiap tetes madu Suwawa adalah cerita tentang keaslian dan komitmen terhadap kualitas"
        </h3>
        
        <!-- Decorative Dots -->
        <div class="flex justify-center space-x-2 mt-8">
            <div class="w-3 h-3 bg-amber-400 rounded-full opacity-60"></div>
            <div class="w-3 h-3 bg-amber-500 rounded-full opacity-80"></div>
            <div class="w-3 h-3 bg-amber-600 rounded-full"></div>
            <div class="w-3 h-3 bg-amber-500 rounded-full opacity-80"></div>
            <div class="w-3 h-3 bg-amber-400 rounded-full opacity-60"></div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-gradient-to-r from-amber-50 to-orange-50">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="bg-white rounded-3xl p-12 shadow-2xl border border-amber-100">
            <h3 class="text-3xl font-bold text-gray-900 mb-4">
                Siap Menikmati Keaslian Madu?
            </h3>
            <p class="text-gray-600 text-lg mb-8 leading-relaxed max-w-2xl mx-auto">
                Dapatkan madu Suwawa berkualitas premium langsung dari alam untuk kesehatan dan kebugaran Anda.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products') }}" 
                   class="group bg-gradient-to-r from-amber-500 to-orange-500 text-white px-8 py-4 rounded-2xl font-bold shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 flex items-center justify-center gap-3">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Beli Madu Suwawa</span>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection