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
        'total_pembayaran',
        'metode',
        'bukti_pembayaran',
        'status_pembayaran',
        'jenis_paket',
        'tgl_pembayaran',
    ];

    protected $casts = [
        'total_pembayaran' => 'decimal:2',
        'tgl_pembayaran' => 'datetime',
    ];

    // Relationships
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'id_invoice');
    }

    public function membership()
    {
        return $this->belongsTo(AkunMembership::class, 'id_membership');
    }

    // Helper methods
    public function isVerified()
    {
        return $this->status_pembayaran === 'verified';
    }

    public function isPending()
    {
        return $this->status_pembayaran === 'pending';
    }
}