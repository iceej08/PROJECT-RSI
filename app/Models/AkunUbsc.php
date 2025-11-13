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

    // Accessor for kategori text
    public function getKategoriTextAttribute()
    {
        return $this->kategori ? 'Warga UB' : 'Umum';
    }

    // Accessor for status badge color
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status_verifikasi) {
            'approved' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Accessor for status text
    public function getStatusTextAttribute()
    {
        return match($this->status_verifikasi) {
            'approved' => 'Disetujui',
            'pending' => 'Menunggu',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
    }
    // Relationships
    public function memberships()
    {
        return $this->hasMany(AkunMembership::class, 'id_akun');
    }

    // Accessor for status badge color
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status_verifikasi) {
            'approved' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }
    
    public function activeMembership()
    {
        return $this->hasOne(AkunMembership::class, 'id_akun')
                    ->where('status', true)
                    ->where('tgl_berakhir', '>=', now());
    }
}
