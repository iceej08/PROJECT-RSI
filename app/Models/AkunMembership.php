<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Pastikan Anda mengimpor Model AkunUbsc
use App\Models\AkunUbsc;

class AkunMembership extends Model
{
    use HasFactory;
    
    // Ini dari screenshot Anda (sudah benar)
    protected $table = 'akun_membership';
    protected $primaryKey = 'id_membership';
    protected $guarded = ['id_membership'];

    // --- INI PERBAIKANNYA ---
    /**
     * Mendapatkan data akun ubsc yang memiliki membership ini.
     *
     * Kita harus memberitahu Laravel 3 hal:
     * 1. Model yang dituju: AkunUbsc::class
     * 2. Foreign Key (kunci tamu) di tabel INI: 'id_akun'
     * 3. Owner Key (kunci utama) di tabel TUJUAN: 'id_akun'
     */
    public function akunUbsc()
    {
        // Kode Anda sebelumnya: return $this->belongsTo(AkunUbsc::class, 'id_akun');
        // Ini salah karena Laravel mengira primary key AkunUbsc adalah 'id'
        
        // Kode yang Benar:
        return $this->belongsTo(AkunUbsc::class, 'id_akun', 'id_akun');
    }

    // Relasi ke Pembayaran (jika diperlukan)
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_membership');
    }
}