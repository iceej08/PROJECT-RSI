<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{
    use HasFactory;

    protected $table = 'promosi';
    protected $primaryKey = 'Id_promosi';
    
    protected $fillable = [
        'Id_admin',
        'Judul',
        'Deskripsi',
        'Gambar',
        'Tgl_mulai',
        'Tgl_berakhir'
    ];

    protected $casts = [
        'Tgl_mulai' => 'datetime',
        'Tgl_berakhir' => 'datetime',
    ];

    // Relasi ke Admin (User)
    public function admin()
    {
        return $this->belongsTo(User::class, 'Id_admin');
    }
}