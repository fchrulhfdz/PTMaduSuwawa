@extends('layouts.admin')

@section('title', 'Detail Keluhan - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">
                <i class="fas fa-eye mr-3 text-gray-600"></i>
                Detail Keluhan & Masukan
            </h1>
            <p class="text-gray-500 mt-1">Detail lengkap pesan dari pelanggan</p>
        </div>
        <a href="{{ route('admin.contacts.index') }}" 
           class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors flex items-center shadow-sm">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Contact Details & Message -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contact Details -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-info-circle mr-3 text-gray-500"></i>
                        <h2 class="text-lg font-medium">Informasi Pengirim</h2>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Nama</label>
                            <p class="text-gray-900 font-medium">{{ $contact->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                            <p class="text-gray-700">
                                <a href="mailto:{{ $contact->email }}" class="flex items-center hover:text-blue-600 transition-colors">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                    {{ $contact->email }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Telepon</label>
                            <p class="text-gray-700">
                                @if($contact->phone)
                                    <a href="tel:{{ $contact->phone }}" class="flex items-center hover:text-green-600 transition-colors">
                                        <i class="fas fa-phone mr-2 text-gray-400"></i>
                                        {{ $contact->phone }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Jenis Masukan</label>
                            @php
                                $subjectLabels = [
                                    'keluhan' => 'Keluhan Produk',
                                    'pelayanan' => 'Keluhan Pelayanan',
                                    'saran' => 'Saran Perbaikan',
                                    'kritik' => 'Kritik Konstruktif',
                                    'pujian' => 'Pujian & Apresiasi',
                                    'lainnya' => 'Lainnya'
                                ];
                                $subjectColors = [
                                    'keluhan' => 'bg-red-50 text-red-700 border-red-200',
                                    'pelayanan' => 'bg-orange-50 text-orange-700 border-orange-200',
                                    'saran' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'kritik' => 'bg-purple-50 text-purple-700 border-purple-200',
                                    'pujian' => 'bg-green-50 text-green-700 border-green-200',
                                    'lainnya' => 'bg-gray-50 text-gray-700 border-gray-200'
                                ];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium border {{ $subjectColors[$contact->subject] ?? 'bg-gray-50 text-gray-700 border-gray-200' }}">
                                {{ $subjectLabels[$contact->subject] ?? $contact->subject }}
                            </span>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Kirim</label>
                            <p class="text-gray-700 flex items-center">
                                <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                {{ $contact->created_at->format('d F Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-envelope mr-3 text-gray-500"></i>
                        <h2 class="text-lg font-medium">Isi Pesan</h2>
                    </div>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-100">
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Status Update & Quick Actions -->
        <div class="space-y-6">
            <!-- Status Update -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-cog mr-3 text-gray-500"></i>
                        <h2 class="text-lg font-medium">Kelola Status</h2>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.contacts.update-status', $contact) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-600 mb-2">Status</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 bg-white" required>
                                <option value="unread" {{ $contact->status == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                                <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                                <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Sudah Dibalas</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="admin_notes" class="block text-sm font-medium text-gray-600 mb-2">Catatan Admin</label>
                            <textarea name="admin_notes" id="admin_notes" rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 bg-white"
                                      placeholder="Tambahkan catatan atau tindakan yang telah dilakukan...">{{ $contact->admin_notes }}</textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center font-medium">
                            <i class="fas fa-save mr-2"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-bolt mr-3 text-gray-500"></i>
                        <h2 class="text-lg font-medium">Aksi Cepat</h2>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="mailto:{{ $contact->email }}?subject=Balasan: {{ $subjectLabels[$contact->subject] ?? $contact->subject }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                           target="_blank">
                            <i class="fas fa-reply mr-2"></i> Balas via Email
                        </a>
                        
                        @if($contact->phone)
                        <a href="https://wa.me/{{ $contact->phone }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                           target="_blank">
                            <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                        </a>
                        @endif
                        
                        <button type="button" 
                                class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                                onclick="confirmDelete()">
                            <i class="fas fa-trash mr-2"></i> Hapus Pesan
                        </button>
                        
                        <form id="deleteForm" action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>

            <!-- Current Status -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-info-circle mr-3 text-gray-500"></i>
                        <h2 class="text-lg font-medium">Status Saat Ini</h2>
                    </div>
                </div>
                <div class="p-6">
                    @php
                        $statusColors = [
                            'unread' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                            'read' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'replied' => 'bg-green-50 text-green-700 border-green-200'
                        ];
                        $statusLabels = [
                            'unread' => 'Belum Dibaca',
                            'read' => 'Sudah Dibaca',
                            'replied' => 'Sudah Dibalas'
                        ];
                    @endphp
                    <div class="flex flex-col items-center justify-center text-center">
                        <span class="inline-flex items-center px-4 py-2 rounded-md text-base font-medium border {{ $statusColors[$contact->status] }} mb-3">
                            {{ $statusLabels[$contact->status] }}
                        </span>
                        <p class="text-sm text-gray-500">
                            Terakhir diupdate: {{ $contact->updated_at->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus pesan ini?')) {
        document.getElementById('deleteForm').submit();
    }
}

// Update status badge when select changes
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const statusBadge = document.querySelector('.inline-flex.items-center.px-4.py-2');
    
    if (statusSelect && statusBadge) {
        const statusColors = {
            'unread': 'bg-yellow-50 text-yellow-700 border-yellow-200',
            'read': 'bg-blue-50 text-blue-700 border-blue-200',
            'replied': 'bg-green-50 text-green-700 border-green-200'
        };
        
        const statusLabels = {
            'unread': 'Belum Dibaca',
            'read': 'Sudah Dibaca',
            'replied': 'Sudah Dibalas'
        };
        
        statusSelect.addEventListener('change', function() {
            const newStatus = this.value;
            // Update badge classes
            statusBadge.className = `inline-flex items-center px-4 py-2 rounded-md text-base font-medium border ${statusColors[newStatus]} mb-3`;
            statusBadge.textContent = statusLabels[newStatus];
        });
    }
});
</script>
@endpush