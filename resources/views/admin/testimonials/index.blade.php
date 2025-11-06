@extends('layouts.admin')

@section('title', 'Kelola Testimonial - Smart Cashier')
@section('subtitle', 'Kelola testimonial pelanggan untuk ditampilkan di halaman user')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Testimonial</h1>
            <p class="text-gray-600">Kelola testimonial pelanggan untuk ditampilkan di halaman user</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" 
           class="bg-gradient-to-r from-pink-500 to-pink-400 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-pink-500/25 transition-all duration-200 flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Tambah Testimonial</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Testimonial</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $testimonials->total() }}</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-comment-alt text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Testimonial Aktif</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $testimonials->where('is_active', true)->count() }}</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Rating Rata-rata</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        {{ number_format($testimonials->avg('rating') ?? 0, 1) }}/5
                    </h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-star text-yellow-500 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Ditampilkan</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $testimonials->where('is_featured', true)->count() }}</h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-eye text-purple-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                <i class="fas fa-list mr-2 text-blue-500"></i>
                Daftar Testimonial
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Testimonial</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($testimonials as $testimonial)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-pink-400 to-pink-300 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ substr($testimonial->customer_name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $testimonial->customer_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $testimonial->customer_title ?? 'Pelanggan' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                @endfor
                                <span class="ml-2 text-sm text-gray-600">({{ $testimonial->rating }})</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $testimonial->testimonial }}">
                                {{ Str::limit($testimonial->testimonial, 80) }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-1">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $testimonial->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $testimonial->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                @if($testimonial->is_featured)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Featured
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $testimonial->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition-colors duration-200 p-2 rounded-lg hover:bg-blue-50"
                                   title="Edit Testimonial">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="toggleStatus({{ $testimonial->id }})" 
                                        class="{{ $testimonial->is_active ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }} transition-colors duration-200 p-2 rounded-lg hover:bg-gray-50"
                                        title="{{ $testimonial->is_active ? 'Sembunyikan dari user' : 'Tampilkan ke user' }}">
                                    <i class="fas {{ $testimonial->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                </button>
                                <button onclick="toggleFeatured({{ $testimonial->id }})" 
                                        class="{{ $testimonial->is_featured ? 'text-gray-600 hover:text-gray-900' : 'text-purple-600 hover:text-purple-900' }} transition-colors duration-200 p-2 rounded-lg hover:bg-gray-50"
                                        title="{{ $testimonial->is_featured ? 'Hapus dari featured' : 'Jadikan featured' }}">
                                    <i class="fas {{ $testimonial->is_featured ? 'fa-star text-yellow-500' : 'fa-star' }}"></i>
                                </button>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus testimonial ini?')"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200 p-2 rounded-lg hover:bg-red-50"
                                            title="Hapus Testimonial">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <i class="fas fa-comment-slash text-4xl mb-4 text-gray-300"></i>
                            <p class="text-lg">Belum ada testimonial</p>
                            <p class="text-sm mt-2">Tambahkan testimonial pertama Anda</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($testimonials->hasPages())
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $testimonials->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(id) {
    if (confirm('Apakah Anda yakin ingin mengubah status tampil testimonial ini?')) {
        // Show loading on the specific button
        const button = document.querySelector(`button[onclick="toggleStatus(${id})"]`);
        const originalHTML = button.innerHTML;
        const originalTitle = button.title;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        button.title = 'Loading...';
        
        fetch(`/admin/testimonials/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const newStatus = data.new_status;
                showNotification(
                    newStatus ? 
                    'Testimonial sekarang ditampilkan ke user!' : 
                    'Testimonial sekarang disembunyikan dari user!', 
                    'success'
                );
                
                // Update button appearance immediately
                const icon = button.querySelector('i');
                if (newStatus) {
                    // Changed to active (green eye)
                    button.classList.remove('text-green-600', 'hover:text-green-900');
                    button.classList.add('text-red-600', 'hover:text-red-900');
                    icon.className = 'fas fa-eye-slash';
                    button.title = 'Sembunyikan dari user';
                } else {
                    // Changed to inactive (red eye-slash)
                    button.classList.remove('text-red-600', 'hover:text-red-900');
                    button.classList.add('text-green-600', 'hover:text-green-900');
                    icon.className = 'fas fa-eye';
                    button.title = 'Tampilkan ke user';
                }
                
                // Update status badge in the table
                updateStatusBadge(id, newStatus);
                
                // Update stats cards after 1 second
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat mengubah status.', 'error');
            // Restore button
            button.innerHTML = originalHTML;
            button.disabled = false;
            button.title = originalTitle;
        });
    }
}

function toggleFeatured(id) {
    if (confirm('Apakah Anda yakin ingin mengubah status featured testimonial ini?')) {
        // Show loading on the specific button
        const button = document.querySelector(`button[onclick="toggleFeatured(${id})"]`);
        const originalHTML = button.innerHTML;
        const originalTitle = button.title;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        button.title = 'Loading...';
        
        fetch(`/admin/testimonials/${id}/toggle-featured`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const newFeatured = data.new_featured;
                showNotification(
                    newFeatured ? 
                    'Testimonial sekarang ditampilkan sebagai featured!' : 
                    'Testimonial dihapus dari featured!', 
                    'success'
                );
                
                // Update button appearance immediately
                const icon = button.querySelector('i');
                if (newFeatured) {
                    // Changed to featured (yellow star)
                    button.classList.remove('text-purple-600', 'hover:text-purple-900');
                    button.classList.add('text-gray-600', 'hover:text-gray-900');
                    icon.className = 'fas fa-star text-yellow-500';
                    button.title = 'Hapus dari featured';
                } else {
                    // Changed to not featured (gray star)
                    button.classList.remove('text-gray-600', 'hover:text-gray-900');
                    button.classList.add('text-purple-600', 'hover:text-purple-900');
                    icon.className = 'fas fa-star';
                    button.title = 'Jadikan featured';
                }
                
                // Update featured badge in the table
                updateFeaturedBadge(id, newFeatured);
                
                // Update stats cards after 1 second
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat mengubah status featured.', 'error');
            // Restore button
            button.innerHTML = originalHTML;
            button.disabled = false;
            button.title = originalTitle;
        });
    }
}

function updateStatusBadge(id, isActive) {
    // Find the status badge for this testimonial
    const row = document.querySelector(`button[onclick="toggleStatus(${id})"]`).closest('tr');
    const statusBadge = row.querySelector('.flex.flex-col.space-y-1 span:first-child');
    
    if (statusBadge) {
        if (isActive) {
            statusBadge.className = 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
            statusBadge.textContent = 'Aktif';
        } else {
            statusBadge.className = 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
            statusBadge.textContent = 'Nonaktif';
        }
    }
}

function updateFeaturedBadge(id, isFeatured) {
    // Find the featured badge for this testimonial
    const row = document.querySelector(`button[onclick="toggleFeatured(${id})"]`).closest('tr');
    const featuredContainer = row.querySelector('.flex.flex-col.space-y-1');
    
    // Remove existing featured badge if any
    const existingFeaturedBadge = featuredContainer.querySelector('.bg-purple-100');
    if (existingFeaturedBadge) {
        existingFeaturedBadge.remove();
    }
    
    // Add featured badge if needed
    if (isFeatured) {
        const featuredBadge = document.createElement('span');
        featuredBadge.className = 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800';
        featuredBadge.textContent = 'Featured';
        featuredContainer.appendChild(featuredBadge);
    }
}

function showNotification(message, type = 'success') {
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-xl shadow-lg transform translate-x-full transition-transform duration-300 z-50`;
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fas ${icon}"></i>
            <span class="font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}
</script>
@endpush