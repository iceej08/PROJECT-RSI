<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunMembership extends Model
{
    use HasFactory;

    protected $table = 'akun_membership';
    protected $primaryKey = 'id_membership';

    protected $fillable = [
        'id_akun',
        'tgl_mulai',
        'tgl_berakhir',
        'status',
    ];

    protected $casts = [
        'tgl_mulai' => 'datetime',
        'tgl_berakhir' => 'datetime',
        'status' => 'boolean',
    ];

    // Relationships
    public function akun()
    {
        return $this->belongsTo(AkunUbsc::class, 'id_akun');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_membership');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_membership');
    }

    public function isActive()
    {
        return $this->status && $this->tgl_berakhir >= now();
    }

    public function daysRemaining()
    {
        if (!$this->isActive()) {
            return 0;
        }
        return now()->diffInDays($this->tgl_berakhir);
    }
}