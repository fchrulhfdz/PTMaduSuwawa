@extends('layouts.admin')

@section('title', 'Keluhan & Masukan - Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-inbox mr-3 text-blue-500"></i>
                Keluhan & Masukan
            </h1>
            <p class="text-gray-600 mt-1">Kelola keluhan dan masukan dari pelanggan</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Pesan -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold">{{ $totalCount }}</div>
                    <div class="text-blue-100 text-sm">Total Pesan</div>
                </div>
                <div class="text-blue-200">
                    <i class="fas fa-inbox text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Belum Dibaca -->
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold">{{ $unreadCount }}</div>
                    <div class="text-yellow-100 text-sm">Belum Dibaca</div>
                </div>
                <div class="text-yellow-200">
                    <i class="fas fa-envelope text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Sudah Dibaca -->
        <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold">{{ $readCount }}</div>
                    <div class="text-cyan-100 text-sm">Sudah Dibaca</div>
                </div>
                <div class="text-cyan-200">
                    <i class="fas fa-envelope-open text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Sudah Dibalas -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-2xl font-bold">{{ $repliedCount }}</div>
                    <div class="text-green-100 text-sm">Sudah Dibalas</div>
                </div>
                <div class="text-green-200">
                    <i class="fas fa-reply text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6">
        <div class="p-6">
            <form action="{{ route('admin.contacts.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Sudah Dibalas</option>
                    </select>
                </div>
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="date_from" id="date_from" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('date_from') }}">
                </div>
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="date_to" id="date_to" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ request('date_to') }}">
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors flex items-center">
                        <i class="fas fa-refresh mr-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Contacts Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center">
                <i class="fas fa-table mr-3 text-gray-500"></i>
                <h2 class="text-lg font-semibold text-gray-800">Daftar Keluhan & Masukan</h2>
            </div>
        </div>
        
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="w-12 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subjek</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($contacts as $contact)
                        <tr class="{{ $contact->status == 'unread' ? 'bg-yellow-50 hover:bg-yellow-100' : 'hover:bg-gray-50' }} transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <input type="checkbox" name="contacts[]" value="{{ $contact->id }}" class="contact-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="font-medium text-gray-900">{{ $contact->name }}</div>
                                    @if($contact->status == 'unread')
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Baru
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $contact->email }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $contact->phone ?? '-' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
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
                                        'keluhan' => 'bg-red-100 text-red-800',
                                        'pelayanan' => 'bg-orange-100 text-orange-800',
                                        'saran' => 'bg-blue-100 text-blue-800',
                                        'kritik' => 'bg-purple-100 text-purple-800',
                                        'pujian' => 'bg-green-100 text-green-800',
                                        'lainnya' => 'bg-gray-100 text-gray-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subjectColors[$contact->subject] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $subjectLabels[$contact->subject] ?? $contact->subject }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'unread' => 'bg-yellow-100 text-yellow-800',
                                        'read' => 'bg-blue-100 text-blue-800',
                                        'replied' => 'bg-green-100 text-green-800'
                                    ];
                                    $statusLabels = [
                                        'unread' => 'Belum Dibaca',
                                        'read' => 'Sudah Dibaca',
                                        'replied' => 'Sudah Dibalas'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$contact->status] }}">
                                    {{ $statusLabels[$contact->status] }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $contact->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" 
                                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                    <button type="button" 
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                            title="Hapus"
                                            onclick="confirmDelete({{ $contact->id }})">
                                        <i class="fas fa-trash mr-1"></i>
                                        Hapus
                                    </button>
                                    <form id="delete-form-{{ $contact->id }}" 
                                          action="{{ route('admin.contacts.destroy', $contact) }}" 
                                          method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                    <p class="text-lg font-medium">Belum ada keluhan atau masukan</p>
                                    <p class="text-sm mt-1">Semua keluhan dan masukan dari pelanggan akan muncul di sini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Bulk Actions -->
            @if($contacts->count() > 0)
            <div class="mt-6 flex items-center space-x-3">
                <select id="bulkAction" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Aksi</option>
                    <option value="mark_read">Tandai sebagai Sudah Dibaca</option>
                    <option value="mark_replied">Tandai sebagai Sudah Dibalas</option>
                    <option value="delete">Hapus Pesan</option>
                </select>
                <button type="button" id="applyBulkAction" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Terapkan
                </button>
            </div>
            @endif

            <!-- Pagination -->
            @if($contacts->hasPages())
            <div class="mt-6 border-t border-gray-200 pt-4">
                {{ $contacts->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(contactId) {
    if (confirm('Apakah Anda yakin ingin menghapus pesan ini?')) {
        document.getElementById('delete-form-' + contactId).submit();
    }
}

// Bulk actions
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.contact-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }

    // Apply bulk action
    const applyBulkAction = document.getElementById('applyBulkAction');
    if (applyBulkAction) {
        applyBulkAction.addEventListener('click', function() {
            const selectedContacts = Array.from(document.querySelectorAll('.contact-checkbox:checked'))
                .map(checkbox => checkbox.value);
            
            const action = document.getElementById('bulkAction').value;
            
            if (selectedContacts.length === 0) {
                alert('Pilih setidaknya satu pesan');
                return;
            }
            
            if (!action) {
                alert('Pilih aksi yang akan dilakukan');
                return;
            }
            
            if (action === 'delete' && !confirm('Apakah Anda yakin ingin menghapus pesan yang dipilih?')) {
                return;
            }
            
            // Submit bulk action form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.contacts.bulk-action") }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;
            form.appendChild(actionInput);
            
            selectedContacts.forEach(contactId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'contacts[]';
                input.value = contactId;
                form.appendChild(input);
            });
            
            document.body.appendChild(form);
            form.submit();
        });
    }
});
</script>
@endpush