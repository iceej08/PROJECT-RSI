<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faq';
    protected $primaryKey = 'Id_FAQ';
    
    protected $fillable = [
        'Id_admin',
        'Pertanyaan',
        'Jawaban'
    ];

    // Relasi ke Admin (jika ada tabel users/admins)
    public function admin()
    {
        return $this->belongsTo(User::class, 'Id_admin');
    }
}