<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faq';
    protected $primaryKey = 'id_faq';
    
    protected $fillable = [
        'Id_admin',
        'pertanyaan',
        'jawaban'
    ];

    // Relasi ke Admin (jika ada tabel users/admins)
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'Id_admin');
    }
}