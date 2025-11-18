<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute; 
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    protected function kategoriText(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->kategori ? 'Warga UB' : 'Umum',
        );
    }

    protected function statusBadgeColor(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status_verifikasi) {
                'approved' => 'bg-green-100 text-green-800',
                'pending' => 'bg-yellow-100 text-yellow-800',
                'rejected' => 'bg-red-100 text-red-800',
                default => 'bg-gray-100 text-gray-800'
            },
        );
    }

    protected function statusText(): Attribute
    {
        return Attribute::make(
            get: fn () => match($this->status_verifikasi) {
                'approved' => 'Disetujui',
                'pending' => 'Menunggu',
                'rejected' => 'Ditolak',
                default => 'Unknown'
            },
        );
    }

    public function memberships(): HasMany
    {
        return $this->hasMany(AkunMembership::class, 'id_akun');
    }
    
    public function activeMembership(): HasOne
    {
        return $this->hasOne(AkunMembership::class, 'id_akun')
                    ->where('status', true) 
                    ->where('tgl_berakhir', '>=', now());
    }
    
    public function latestMembership(): HasOne
    {
        return $this->hasOne(AkunMembership::class, 'id_akun')->latestOfMany('created_at');
    }
    
    public function membership(): HasOne
    {
        return $this->latestMembership();
    }
}
