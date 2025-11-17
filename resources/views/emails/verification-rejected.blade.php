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
            background-color: #004a73;
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
            <h2>Pemberitahuan Verifikasi Akun</h2>
            <p>Halo <strong>{{ $account->nama_lengkap }}</strong>,</p>
            <p>Terima kasih telah mendaftar di UB Sport Center.</p>
            
            <p>Setelah melakukan review terhadap dokumen identitas yang Anda upload, kami tidak dapat memverifikasi akun Anda sebagai Warga UB. Namun, akun Anda telah dikategorikan sebagai <strong>Pengguna Umum</strong>.</p>

            <p><strong>Detail Akun:</strong></p>
            <ul>
                <li>Nama: {{ $account->nama_lengkap }}</li>
                <li>Email: {{ $account->email }}</li>
                <li>Kategori: Umum</li>
                <li>Status: Aktif</li>
                <li>Tanggal Daftar: {{ $account->tgl_daftar->format('d F Y') }}</li>
            </ul>

            <p>Anda tetap dapat login dan menggunakan seluruh fasilitas UB Sport Center dengan paket untuk pengguna umum.</p>

            <p>Jika Anda merasa ini adalah kesalahan atau memiliki pertanyaan lebih lanjut, silakan hubungi admin kami.</p>

            <a href="{{ url('/login') }}" class="button">Login Sekarang</a>

            <p style="margin-top: 30px;">Terima kasih atas pengertiannya.</p>
            
            <p>Salam,<br><strong>Tim UB Sport Center</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} UB Sport Center. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>