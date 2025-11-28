<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_invoice',
        'id_membership',
        'metode',
        'jenis_paket',
        'total_pembayaran',
        'tgl_pembayaran',
        'status_pembayaran',
        'bukti_pembayaran',
        'alasan_penolakan', 
    ];

    protected $casts = [
        'tgl_pembayaran' => 'datetime',
        'total_pembayaran' => 'decimal:2',
    ];

    // Relationships
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'id_invoice', 'id_invoice');
    }

    public function membership()
    {
        return $this->belongsTo(AkunMembership::class, 'id_membership', 'id_membership');
    }
}