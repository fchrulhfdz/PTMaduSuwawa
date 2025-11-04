@extends('layouts.admin')

@section('title', 'Kelola Testimonial - Madu Suwawa')

@section('content')
<div class="flex justify-center p-8">
    <div class="w-full max-w-7xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Kelola Testimonial</h1>
                <p class="text-gray-600">Kelola testimonial pelanggan untuk ditampilkan di halaman user</p>
            </div>
            <a href="{{ route('admin.testimonials.create') }}" 
               class="bg-gradient-to-r from-amber-500 to-amber-400 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-amber-500/25 transition-all duration-200 flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Testimonial</span>
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Testimonial</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $testimonials->total() }}</h3>
                    </div>
                    <div class="p-3 bg-amber-100 rounded-xl">
                        <i class="fas fa-comment-alt text-amber-500 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Testimonial Aktif</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $testimonials->where('is_active', true)->count() }}</h3>
                    </div>
                    <div class="p-3 bg-green-100 rounded-xl">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Rating Rata-rata</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">
                            {{ number_format($testimonials->avg('rating') ?? 0, 1) }}/5
                        </h3>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-xl">
                        <i class="fas fa-star text-blue-500 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Ditampilkan</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $testimonials->where('is_featured', true)->count() }}</h3>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <i class="fas fa-eye text-purple-500 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Daftar Testimonial</h2>
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
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-r from-amber-400 to-amber-300 rounded-full flex items-center justify-center text-white font-bold">
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
                                        <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-gray-300' }} text-sm"></i>
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
                                       class="text-amber-600 hover:text-amber-900 transition-colors duration-200 p-2 rounded-lg hover:bg-amber-50"
                                       title="Edit Testimonial">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="toggleStatus({{ $testimonial->id }})" 
                                            class="{{ $testimonial->is_active ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }} transition-colors duration-200 p-2 rounded-lg hover:bg-gray-50"
                                            title="{{ $testimonial->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas {{ $testimonial->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    </button>
                                    <button onclick="toggleFeatured({{ $testimonial->id }})" 
                                            class="{{ $testimonial->is_featured ? 'text-gray-600 hover:text-gray-900' : 'text-purple-600 hover:text-purple-900' }} transition-colors duration-200 p-2 rounded-lg hover:bg-gray-50"
                                            title="{{ $testimonial->is_featured ? 'Hapus Featured' : 'Jadikan Featured' }}">
                                        <i class="fas {{ $testimonial->is_featured ? 'fa-star' : 'fa-star' }}"></i>
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
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                {{ $testimonials->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(id) {
    if (confirm('Apakah Anda yakin ingin mengubah status testimonial ini?')) {
        // Show loading on the specific button
        const button = document.querySelector(`button[onclick="toggleStatus(${id})"]`);
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
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
                showNotification('Status testimonial berhasil diubah!', 'success');
                // Reload after 1 second
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
        });
    }
}

function toggleFeatured(id) {
    if (confirm('Apakah Anda yakin ingin mengubah status featured testimonial ini?')) {
        // Show loading on the specific button
        const button = document.querySelector(`button[onclick="toggleFeatured(${id})"]`);
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
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
                showNotification('Status featured testimonial berhasil diubah!', 'success');
                // Reload after 1 second
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
        });
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