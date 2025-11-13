<!DOCTYPE html>
<html lang="en">
<head>
     <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #004a73;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #10b981;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>UB Sport Center</h1>
        </div>
        <div class="content">
            <h2>Selamat! Akun Anda Telah Diverifikasi</h2>
            <p>Halo <strong>{{ $account->nama_lengkap }}</strong>,</p>
            <p>Kami dengan senang hati memberitahukan bahwa akun Anda sebagai <strong>Warga UB</strong> telah berhasil diverifikasi oleh admin UB Sport Center.</p>
            
            <p><strong>Detail Akun:</strong></p>
            <ul>
                <li>Nama: {{ $account->nama_lengkap }}</li>
                <li>Email: {{ $account->email }}</li>
                <li>Kategori: Warga UB</li>
                <li>Status: Disetujui</li>
                <li>Tanggal Daftar: {{ $account->tgl_daftar->format('d F Y') }}</li>
            </ul>

            <p>Anda sekarang dapat login dan menikmati semua fasilitas yang tersedia di UB Sport Center dengan benefit khusus untuk Warga UB.</p>

            <a href="{{ url('/login') }}" class="button">Login Sekarang</a>

            <p style="margin-top: 30px;">Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
            
            <p>Terima kasih,<br><strong>Tim UB Sport Center</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} UB Sport Center. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>