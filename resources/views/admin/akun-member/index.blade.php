@extends('layouts.admin')

@section('title', 'Manajemen Akun Member - Admin UBSC')
@section('page-title', 'Manajemen Akun Member')

@section('content')
<div class="bg-white rounded-xl shadow-md">
    <div class="p-6 border-b flex items-center justify-between">
        <div>
            <button onclick="openAddModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg flex items-center transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Akun Member
            </button>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari akun UBSC..." 
                       class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>
        </div>

        <!-- Add Member Modal -->
        <div id="addModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-8 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white">
                <div class="flex justify-between items-center pb-3 border-b mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Tambah Member</h3>
                    <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <form action="{{ route('admin.akun-member.tambahMember') }}" method="POST" id="addMemberForm">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih User</label>
                        <select name="id_akun" id="id_akun_select" required onchange="updatePrices()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="">-- Pilih User --</option>
                            @foreach(App\Models\AkunUbsc::whereDoesntHave('memberships')->where('status_verifikasi', '!=', 'pending')->orderBy('nama_lengkap')->get() as $user)
                                @php
                                    $lastMembership = App\Models\AkunMembership::where('id_akun', $user->id_akun)
                                        ->orderBy('tgl_berakhir', 'desc')
                                        ->first();
                                    
                                    $needsFee = false;
                                    if (!$lastMembership) {
                                        $needsFee = true;
                                    } else {
                                        $twoMonthsAgo = \Carbon\Carbon::now()->subMonths(2);
                                        if ($lastMembership->tgl_berakhir < $twoMonthsAgo) {
                                            $needsFee = true;
                                        }
                                    }
                                @endphp
                                <option value="{{ $user->id_akun }}" 
                                        data-kategori="{{ $user->kategori ? '1' : '0' }}"
                                        data-needs-fee="{{ $needsFee ? '1' : '0' }}">
                                    {{ $user->nama_lengkap }} ({{ $user->email }}) - {{ $user->kategori ? 'Warga UB' : 'Umum' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Hanya menampilkan user yang belum memiliki membership aktif</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Paket Member</label>
                        <select name="jenis_paket" id="jenis_paket_select" required onchange="updatePrices()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="">Pilihan Paket</option>
                            <option value="harian">Harian</option>
                            <option value="bulanan">Bulanan</option>
                        </select>
                    </div>

                    <!-- Price Breakdown (dinamis berdasarkan kategori user) -->
                    <div id="price_breakdown" class="hidden mb-6 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-3">Rincian Biaya:</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Paket <span id="paket_name"></span></span>
                                <span class="font-medium" id="paket_price"></span>
                            </div>
                            <div id="biaya_pendaftaran_row" class="flex justify-between">
                                <span class="text-gray-600">Biaya Pendaftaran Awal</span>
                                <span class="font-medium" id="biaya_pendaftaran"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium" id="subtotal_price"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pajak (10%)</span>
                                <span class="font-medium" id="tax_price"></span>
                            </div>
                            <div class="border-t pt-2 flex justify-between">
                                <span class="font-bold text-gray-800">Total</span>
                                <span class="font-bold text-[#004a73]" id="total_price"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                        <select name="metode_pembayaran" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="transfer_bank">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-3 mt-8">
                        <button type="button" onclick="closeAddModal()" 
                                class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-6 py-3 bg-[#004a73] text-white rounded-lg hover:bg-[#003d5e] transition">
                            Tambah Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Mulai</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Berakhir</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($members as $member)
                            @php
                                $membership = $member->activeMembership ?? $member->memberships->first();
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ str_pad($membership->id_membership, 6, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $member->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $member->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if($membership)
                                        {{ $membership->tgl_mulai->format('d F Y') }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    @if($membership)
                                        {{ $membership->tgl_berakhir->format('d F Y') }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($membership)
                                        @if($membership->status && $membership->tgl_berakhir >= now())
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                                        @elseif($membership->tgl_berakhir->copy()->addMonths(2) < now())
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Kedaluwarsa</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">Non-Aktif</span>
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <button 
                                        onclick="openEditModal({{ $member->id_akun }})" 
                                        class="text-blue-600 hover:text-blue-800 mr-3"
                                        title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button 
                                        onclick="confirmDelete({{ $member->id_akun }})"
                                        class="text-red-600 hover:text-red-800"
                                        title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>

                                    <!-- Delete Form (Hidden) -->
                                    <form id="delete-form-{{ $member->id_akun }}" 
                                            action="{{ route('admin.akun-member.destroy', $membership->id_membership) }}" 
                                            method="POST" 
                                            class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <!-- Edit Modal -->
                                    <div id="editModal{{ $member->id_akun }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                                        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white">
                                            <div class="flex justify-between items-center pb-3 border-b">
                                                <h3 class="text-xl font-bold">Edit Member Account</h3>
                                                <button onclick="closeEditModal({{ $member->id_akun }})" class="text-gray-400 hover:text-gray-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                            
                                            <form action="{{ route('admin.akun-member.update', $membership->id_membership) }}" method="POST" class="mt-4">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="grid grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                                        <input type="text" name="nama_lengkap" value="{{ $member->nama_lengkap }}" disabled
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                                        <input type="email" name="email" value="{{ $member->email }}" disabled
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                                        <input type="text" value="{{ $member->kategori ? 'Warga UB' : 'Umum' }}" disabled
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">
                                                    </div>
                                                </div>

                                                @if($membership)
                                                    <hr class="my-4">
                                                    <h4 class="font-semibold mb-4">Membership Details</h4>
                                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                                            <input type="date" name="tgl_mulai" value="{{ $membership->tgl_mulai->format('Y-m-d') }}"
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Berakhir</label>
                                                            <input type="date" name="tgl_berakhir" value="{{ $membership->tgl_berakhir->format('Y-m-d') }}"
                                                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                                        </div>
                                                        <div class="col-span-2">
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Membership</label>
                                                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                                                <option value="1" {{ $membership->status ? 'selected' : '' }}>Aktif</option>
                                                                <option value="0" {{ !$membership->status ? 'selected' : '' }}>Non-aktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="membership_id" value="{{ $membership->id_membership }}">
                                                @endif

                                                <div class="flex justify-end space-x-3 mt-6">
                                                    <button type="button" onclick="closeEditModal({{ $member->id_akun }})" 
                                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                                        Batal
                                                    </button>
                                                    <button type="submit" 
                                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                        Simpan Perubahan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-gray-500">Tidak ada data member</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $members->links() }}
        </div>
</div>
@endsection
@push('scripts')
<script>
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    function updateTotalBayar() {
        const select = document.getElementById('jenis_paket');
        const selectedOption = select.options[select.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        
        if (price) {
            document.getElementById('total_bayar').value = price;
            document.getElementById('total_bayar_display').value = 'Rp ' + parseInt(price).toLocaleString('id-ID');
        } else {
            document.getElementById('total_bayar').value = '0';
            document.getElementById('total_bayar_display').value = 'Rp 0';
        }
    }

    function openEditModal(id) {
        document.getElementById('editModal' + id).classList.remove('hidden');
    }

    function closeEditModal(id) {
        document.getElementById('editModal' + id).classList.add('hidden');
    }

    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus akun member ini? Semua data membership terkait juga akan dihapus.')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('bg-opacity-50')) {
            event.target.classList.add('hidden');
        }
    }
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