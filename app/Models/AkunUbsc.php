<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AkunUbsc extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'akun_ubsc';
    protected $primaryKey = 'id_akun';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'kategori',
        'foto_identitas',
        'status_verifikasi',
        'tgl_daftar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'kategori' => 'boolean',
        'tgl_daftar' => 'date',
    ];

    // Relationships
    public function memberships()
    {
        return $this->hasMany(AkunMembership::class, 'id_akun');
    }

    public function activeMembership()
    {
        return $this->hasOne(AkunMembership::class, 'id_akun')
                    ->where('status', true)
                    ->where('tgl_berakhir', '>=', now());
    }
}
