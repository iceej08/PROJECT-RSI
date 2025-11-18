<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-blue-100 min-h-screen p-4 md:p-8">
    @include('alert')
    <div class="max-w-3xl mx-auto">
        <!-- Invoice Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-[#1e3a5f] text-white p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">UBSC INVOICE</h1>
                        <p class="text-sm text-blue-200">Subscription Management System</p>
                        <div class="mt-4 text-sm">
                            <p>PT. Brawijaya Multi Usaha</p>
                            <p>Jl. Terusan Cibogo No.1, Penanggungan </p>
                            <p>Email: billing@ubsc.com | Tel: 062-21-123-4567</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-blue-200">Invoice Number</p>
                        <p class="text-xl font-bold">INV-{{ date('Ymd') }}-{{ str_pad($invoice->id_invoice, 6, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-sm text-blue-200 mt-2">Issue Date</p>
                        <p class="font-medium">{{ $invoice->tgl_terbit->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Invoice Items
                    </h2>
                    
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="border-b">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Deskripsi</th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600">Pilihan Paket</th>
                                <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600">Periode</th>
                                <th class="text-right py-3 px-4 text-sm font-semibold text-gray-600">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="py-4 px-4">
                                    <p class="font-medium">Membership {{ ucfirst($invoice->jenis_paket) }}</p>
                                    <p class="text-sm text-gray-500">Akses ke semua fitur member, termasuk berolahraga di Gym & Fitness UBSC</p>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                        Membership {{ $invoice->jenis_paket === 'harian' ? 'Harian' : 'Bulanan' }} 
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center text-sm">
                                    {{ $invoice->transaksi->membership->tgl_mulai->format('d M') }} - {{ $invoice->transaksi->membership->tgl_berakhir->format('d M Y') }}
                                </td>
                                <td class="py-4 px-4 text-right font-medium">
                                    Rp {{ number_format($harga[$invoice->jenis_paket], 0, ',', '.') }}
                                </td>
                            </tr>

                            {{-- @if($harga['biaya_pendaftaran'] > 0) --}}
                            <tr class="border-b">
                                <td class="py-4 px-4" colspan="3">
                                    <p class="font-medium">Biaya Pendaftaran Awal</p>
                                    <p class="text-sm text-gray-500">One-time registration fee</p>
                                </td>
                                <td class="py-4 px-4 text-right font-medium">
                                    Rp {{ number_format($harga['biaya_pendaftaran'], 0, ',', '.') }}
                                </td>
                            </tr>
                            {{-- @endif --}}

                        </tbody>
                    </table>
                </div>

                <!-- Billing Summary -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="font-bold text-gray-800 mb-3">Billing Summary</h3>
                    @php
                        $subtotal = $harga[$invoice->jenis_paket] + $harga['biaya_pendaftaran'];
                        $tax = $subtotal * 0.10;
                    @endphp
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax (10%)</span>
                            <span class="font-medium">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>

                        @if($harga['biaya_pendaftaran'] > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Biaya Pendaftaran Awal</span>
                            <span class="font-medium">Rp {{ number_format($harga['biaya_pendaftaran'], 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <div class="border-t pt-2 flex justify-between">
                            <span class="font-bold text-lg">Total Amount</span>
                            <span class="font-bold text-xl text-[#1e3a5f]">Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method & Due Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Payment Method -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Payment Method
                        </h3>
                        <p class="text-sm mb-1">Transfer Bank</p>
                        <p class="text-sm font-medium">BCA 1234567890</p>
                        <p class="text-sm">A.N. UB Sport Center</p>
                        <div class="mt-2 pt-2 border-t border-blue-200">
                            <p class="text-sm font-medium">Q-RIS</p>
                            <button onclick="document.getElementById('qrisModal').classList.remove('hidden')" 
                                    class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Tampilkan QRIS
                            </button>
                        </div>
                    </div>

                    <!-- Payment Due -->
                    <div class="bg-red-50 p-4 rounded-lg">
                        <h3 class="font-bold text-gray-800 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Payment Due
                        </h3>
                        @php
                            $dueDate = $invoice->tgl_terbit->addDays(1);
                        @endphp
                        <p class="text-xl font-bold text-red-600">{{ $dueDate->format('d F Y') }}</p>
                        <p class="text-sm text-gray-600 mt-1">Pembayaran harus dilakukan dalam 1x24 Jam</p>
                    </div>
                </div>

                <!-- Upload Payment Proof -->
                @if(!$invoice->pembayaran || $invoice->pembayaran->status_pembayaran === 'rejected')
                <div class="bg-gradient-to-r from-orange-50 to-orange-100 p-6 rounded-lg mb-4">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        Unggah Bukti Pembayaran
                    </h3>
                    
                    @if($invoice->pembayaran && $invoice->pembayaran->status_pembayaran === 'rejected')
                        <div class="mb-4 p-3 bg-red-100 border border-red-300 rounded text-red-700 text-sm">
                            ❌ Bukti pembayaran sebelumnya ditolak. Silakan upload ulang.
                        </div>
                    @endif

                    <form action="{{ route('pelanggan.invoice.unggah-bukti', $invoice->id_invoice) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                            <select name="metode" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="transfer_bank">Transfer Bank</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">File Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" accept="image/*" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                        </div>

                        <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-lg transition flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Unggah Bukti Pembayaran
                        </button>
                    </form>
                </div>
                @elseif($invoice->pembayaran && $invoice->pembayaran->status_pembayaran === 'pending')
                <div class="bg-yellow-50 p-6 rounded-lg mb-4 text-center">
                    <svg class="w-16 h-16 mx-auto text-yellow-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="font-bold text-gray-800 mb-2">Menunggu Verifikasi Admin</h3>
                    <p class="text-sm text-gray-600">Bukti pembayaran Anda sedang diverifikasi oleh admin. Mohon tunggu maksimal 1x24 jam dan coba reload secara berkala.</p>
                </div>
                @elseif($invoice->pembayaran && $invoice->pembayaran->status_pembayaran === 'verified')
                <div class="bg-green-50 p-6 rounded-lg mb-4 text-center">
                    <svg class="w-16 h-16 mx-auto text-green-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="font-bold text-gray-800 mb-2">Pembayaran Terverifikasi!</h3>
                    <p class="text-sm text-gray-600 mb-4">Selamat! Membership Anda sudah aktif.</p>
                    <a href="{{ route('profile') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                        Cek Profil Member Kamu!
                    </a>
                </div>
                @endif

                
                <!-- Download Button -->
                <div class="flex justify-center space-x-4">
                    <span>
                    <button onclick="window.print()" class="bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Invoice
                    </button>
                    </span>
                    <form action="{{ route('pelanggan.invoice.cancel', $invoice->id_invoice) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 border-2 border-gray-300 text-gray-600 px-6 py-3 rounded-lg hover:bg-red-700 transition flex items-center">
                            Kembali & Pilih Paket Lain
                        </button>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-[#1e3a5f] text-white text-center py-4 text-sm">
                <p>Terima kasih telah memilih UBSC! Jika ada pertanyaan lebih lanjut, mohon hubungi pusat bantuan.</p>
                <p class="mt-1">Invoice ini dibuat secara otomatis. Simpan invoice ini untuk catatan pribadi.</p>
            </div>
        </div>
    </div>

    <!-- QRIS Modal -->
    <div id="qrisModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
            <div class="text-center">
                <h3 class="text-lg font-bold mb-4">Scan QRIS untuk Pembayaran</h3>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=QRIS-{{ $invoice->id_invoice }}" alt="QRIS" class="mx-auto mb-4">
                <button onclick="document.getElementById('qrisModal').classList.add('hidden')" 
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</body>
</html>