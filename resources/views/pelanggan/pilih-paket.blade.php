<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pilih Paket Member</title>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-size: cover;
            background-position: top;
            
        }
        .package-card {
            transition: all 0.3s ease;
        }
        .package-card:hover {
            transform: translateY(-5px);
        }
        .package-card.selected {
            border: 3px solid #1e40af;
            box-shadow: 0 0 20px rgba(30, 64, 175, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-3" style="background-image: url({{ asset('images/bgPilihPaket.png') }});">
    <div class="w-full max-w-2xl max-h-full">
        <!-- Card Container -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl p-8 md:p-12">
            <!-- Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-[#1e3a5f] text-center mb-8">
                Registrasi Membership
            </h1>

            @include('alert')

            <form action="{{ route('pelanggan.buat-invoice') }}" method="POST" id="packageForm">
                @csrf
                <input type="hidden" name="jenis_paket" id="selected_package">
                {{-- pemilihan paket --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="group cursor-pointer rounded-2xl p-6 border-2 transition-all duration-300 hover:-translate-y-1 border-gray-200 bg-white hover:border-blue-300"
                    onclick="selectPackage('harian', {{ $harga['harian'] }}, {{ $harga['biaya_pendaftaran'] }})"
                         data-package="harian"
                         onclick="selectPackage('harian', {{ $harga['harian'] }}, {{ $harga['biaya_pendaftaran'] }})">
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-2">Membership Harian</p>
                            <p class="text-4xl font-bold text-[#1e3a5f] mb-4">
                                {{ number_format($harga['harian'] / 1000, 0) }}k
                            </p>
                            <div class="text-xs text-gray-500 space-y-1 mb-3">
                                <p>Akses 1 Hari</p>
                                <p>Semua Fasilitas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bulanan Package -->
                    <div class="group cursor-pointer rounded-2xl p-6 border-2 transition-all duration-300 hover:-translate-y-1 border-gray-200 bg-white hover:border-blue-300"
                         data-package="bulanan"
                         onclick="selectPackage('bulanan', {{ $harga['bulanan'] }}, {{ $harga['biaya_pendaftaran'] }})">
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-2">Membership Bulanan</p>
                            <p class="text-4xl font-bold text-[#1e3a5f] mb-4">
                                {{ number_format($harga['bulanan'] / 1000, 0) }}k
                            </p>
                            <div class="text-xs text-gray-500 space-y-1 mb-3">
                                <p>Akses 30 Hari</p>
                                <p>Semua Fasilitas</p>
                                <p class="text-green-600 font-semibold">Hemat!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price Breakdown -->
                <div id="priceBreakdown" class="hidden mb-5 p-2 bg-gray-50 rounded-lg">
                    <h3 class="font-semibold text-gray-800 mb-3">Rincian Biaya:</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Paket <span id="package_name"></span></span>
                            <span class="font-medium" id="package_price"></span>
                        </div>
                        @if($harga['biaya_pendaftaran'] > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Pendaftaran Awal</span>
                            <span class="font-medium">Rp {{ number_format($harga['biaya_pendaftaran'], 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium" id="subtotal"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Pajak (10%)</span>
                            <span class="font-medium" id="tax"></span>
                        </div>
                        <div class="border-t pt-2 flex justify-between">
                            <span class="font-bold text-gray-800">Total</span>
                            <span class="font-bold text-[#1e3a5f]" id="total"></span>
                        </div>
                    </div>
                </div>

                <!-- Info Message -->
                @if($harga['biaya_pendaftaran'] > 0)
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 text-blue-700 rounded-lg text-sm">
                    <p class="font-semibold mb-1">ℹ️ Biaya Pendaftaran</p>
                    <p>Biaya pendaftaran awal sebesar Rp {{ number_format($harga['biaya_pendaftaran'], 0, ',', '.') }}, dikenakan untuk pendaftaran pertama kali —atau karena Anda sudah tidak aktif > 2 bulan T-T</p>
                </div>
                @endif

                <!-- Submit Button -->
                <button 
                    type="submit"
                    id="confirmBtn"
                    disabled
                    class="w-full bg-[#1e3a5f] text-white font-bold py-4 px-6 rounded-full disabled:bg-gray-400 disabled:cursor-not-allowed hover:bg-[#152844] transition duration-300 uppercase tracking-wide shadow-lg">
                    Konfirmasi
                </button>
            </form>
        </div>
    </div>

<script>
    let selectedPackage = null;
    const biayaPendaftaran = {{ $harga['biaya_pendaftaran'] }};

    function selectPackage(type, price, registrationFee) {
        selectedPackage = type;
        document.getElementById('selected_package').value = type;
        
        // Update UI
        document.querySelectorAll('.package-card').forEach(card => {
            card.classList.remove('selected');
        });
        event.currentTarget.classList.add('selected');

        // Calculate harga
        const subtotal = price + registrationFee;
        const tax = Math.round(subtotal * 0.10);
        const total = subtotal + tax;

        // Update price breakdown
        document.getElementById('package_name').textContent = type === 'harian' ? 'Harian' : 'Bulanan';
        document.getElementById('package_price').textContent = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('tax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
        document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');

        // Show breakdown
        document.getElementById('priceBreakdown').classList.remove('hidden');
        
        // Enable button
        document.getElementById('confirmBtn').disabled = false;
    }
</script>
</body>
</html>