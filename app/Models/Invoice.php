<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $primaryKey = 'id_invoice';

    protected $fillable = [
        'id_transaksi',
        'jenis_paket',
        'tgl_terbit',
        'total_tagihan',
        'status_kirim',
    ];

    protected $casts = [
        'tgl_terbit' => 'datetime',
        'total_tagihan' => 'decimal:2',
    ];

    // Relationships
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_invoice');
    }

    // Helper methods
    // public function generateInvoiceNumber()
    // {
    //     return 'INV-' . date('Ymd') . '-' . str_pad($this->id_invoice, 6, '0', STR_PAD_LEFT);
    // }
}