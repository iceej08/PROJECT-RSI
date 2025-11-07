<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable{
    use HasFactory, Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function faqs()
    {
        return $this->hasMany(Faq::class, 'id_admin');
    }
}