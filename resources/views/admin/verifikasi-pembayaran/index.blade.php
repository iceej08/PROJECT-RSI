@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Verifikasi Pembayaran')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pembayaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Pembayaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pembayarans as $pembayaran)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $pembayaran->id_pembayaran }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $pembayaran->invoice->transaksi->membership->akun->nama_lengkap }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        Rp {{ number_format($pembayaran->total_pembayaran, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ ucwords(str_replace('_', ' ', $pembayaran->metode)) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($pembayaran->status_pembayaran === 'pending')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @elseif($pembayaran->status_pembayaran === 'verified')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Berhasil
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Gagal
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($pembayaran->bukti_pembayaran)
                            <button onclick="viewBukti({{ $pembayaran->id_pembayaran }})" 
                                    class="text-blue-600 hover:text-blue-900 font-medium">
                                Lihat Bukti
                            </button>
                        @else
                            <span class="text-gray-400">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if($pembayaran->status_pembayaran === 'pending')
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.verifikasi-pembayaran.approve', $pembayaran->id_pembayaran) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menyetujui pembayaran ini?')">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition">
                                        Accept
                                    </button>
                                </form>
                                
                                <button onclick="openRejectModal({{ $pembayaran->id_pembayaran }}, '{{ $pembayaran->invoice->transaksi->membership->akun->nama_lengkap }}')" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition">
                                    Reject
                                </button>
                            </div>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data pembayaran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal View Bukti Pembayaran -->
<div id="buktiModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Detail Bukti Pembayaran</h3>
            <button onclick="closeBuktiModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div id="buktiContent" class="space-y-4">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<!-- Modal Reject dengan Form Alasan -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-900">Tolak Pembayaran</h3>
            <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <form id="rejectForm" method="POST">
            @csrf
            
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">
                    Anda akan menolak pembayaran dari: <span id="rejectNama" class="font-semibold text-gray-900"></span>
                </p>
            </div>

            <div class="mb-4">
                <label for="alasan" class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Penolakan <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="alasan" 
                    id="alasan" 
                    rows="4" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                    placeholder="Contoh: Bukti transfer tidak jelas, nominal tidak sesuai, rekening pengirim tidak valid, dll."></textarea>
                <p class="mt-1 text-xs text-gray-500">Alasan ini akan dikirimkan kepada pengguna via email</p>
            </div>

            <div class="flex justify-end space-x-3">
                <button 
                    type="button" 
                    onclick="closeRejectModal()" 
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                    Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// View Bukti Pembayaran
function viewBukti(id) {
    fetch(`/admin/verifikasi-pembayaran/bukti/${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('buktiContent').innerHTML = `
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama</p>
                            <p class="font-semibold">${data.nama}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-semibold">${data.email}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jenis Paket</p>
                            <p class="font-semibold">${data.jenis_paket}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Pembayaran</p>
                            <p class="font-semibold">Rp ${data.total_pembayaran}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Metode</p>
                            <p class="font-semibold">${data.metode}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pembayaran</p>
                            <p class="font-semibold">${data.tgl_pembayaran}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">ID Pembayaran</p>
                            <p class="font-semibold">${data.id_pembayaran}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">No. Invoice</p>
                            <p class="font-semibold">${data.invoice_number}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Bukti Transfer</p>
                        <img src="${data.bukti_url}" alt="Bukti Pembayaran" class="w-full rounded-lg border border-gray-300">
                    </div>
                `;
                document.getElementById('buktiModal').classList.remove('hidden');
            } else {
                alert('Gagal memuat bukti pembayaran');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat data');
        });
}

function closeBuktiModal() {
    document.getElementById('buktiModal').classList.add('hidden');
}

// Reject Modal Functions
function openRejectModal(id, nama) {
    document.getElementById('rejectNama').textContent = nama;
    document.getElementById('rejectForm').action = `/admin/verifikasi-pembayaran/reject/${id}`;
    document.getElementById('alasan').value = '';
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const buktiModal = document.getElementById('buktiModal');
    const rejectModal = document.getElementById('rejectModal');
    
    if (event.target === buktiModal) {
        closeBuktiModal();
    }
    if (event.target === rejectModal) {
        closeRejectModal();
    }
}

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeBuktiModal();
        closeRejectModal();
    }
});
</script>
@endpush