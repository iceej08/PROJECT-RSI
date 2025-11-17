<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_membership',
        'jenis_paket',
        'tgl_transaksi',
        'total_tagihan',
        'status_transaksi',
    ];

    protected $casts = [
        'tgl_transaksi' => 'datetime',
        'total_tagihan' => 'decimal:2',
    ];

    // Relationships
    public function membership()
    {
        return $this->belongsTo(AkunMembership::class, 'id_membership');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'id_transaksi');
    }

    // Helper methods
    // public static function getPackagePrices()
    // {
    //     return [
    //         'bulanan' => 120000,
    //         'harian' => 25000,
    //     ];
    // }

    // public function getPackageDuration()
    // {
    //     $durations = [
    //         'bulanan' => 30,
    //         'harian' => 1,
    //     ];
    //     return $durations[$this->jenis_paket] ?? 0;
    // }
}