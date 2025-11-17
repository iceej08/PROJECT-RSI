@extends('layouts.admin')

@section('title', 'Verification UBSC - Admin Panel')
@section('page-title', 'Verification UBSC')

@section('content')
<div class="bg-white rounded-xl shadow-md">
    <div class="p-6 border-b flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Daftar Warga UB Menunggu Verifikasi</h3>
            <p class="text-sm text-gray-600 mt-1">Total: {{ $accounts->count() }} akun</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari akun..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Akun</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto Identitas UB</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Upload</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($accounts as $account)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ str_pad($account->id_akun, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $account->nama_lengkap }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $account->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button onclick="viewPhoto({{ $account->id_akun }})" class="px-3 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition text-sm font-medium">
                            Lihat Foto
                        </button>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 text-xs font-semibold text-yellow-600 bg-yellow-100 rounded-full">Menunggu Verifikasi</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $account->created_at->format('d M Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="mt-2 text-gray-500">Tidak ada akun yang menunggu verifikasi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Photo Modal -->
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-800">Verifikasi Foto Identitas UB</h3>
            <button onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <div id="photoContent" class="p-6">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewPhoto(id) {
    fetch(`/admin/verification/photo/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('photoContent').innerHTML = `
                    <div class="space-y-4">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Nama</p>
                            <p class="font-semibold text-gray-800">${data.nama}</p>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-semibold text-gray-800">${data.email}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Foto Identitas</p>
                            <img src="${data.photo_url}" alt="Foto Identitas" class="w-full rounded-lg border">
                        </div>
                        <div class="flex gap-4 pt-4">
                            <form action="/admin/verification/reject/${id}" method="POST" class="flex-1">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 rounded-lg transition">
                                    Tolak (Umum)
                                </button>
                            </form>
                            <form action="/admin/verification/approve/${id}" method="POST" class="flex-1">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition">
                                    Setuju (Warga UB)
                                </button>
                            </form>
                        </div>
                    </div>
                `;
                document.getElementById('photoModal').classList.remove('hidden');
                document.getElementById('photoModal').classList.add('flex');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat foto identitas');
        });
}

function closePhotoModal() {
    document.getElementById('photoModal').classList.add('hidden');
    document.getElementById('photoModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('photoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePhotoModal();
    }
});

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});
</script>
@endpush