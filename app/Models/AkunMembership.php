<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AkunMembership extends Model
{
    use HasFactory;

    protected $table = 'akun_membership'; 
    protected $primaryKey = 'id_membership';
    public $timestamps = true;
    
    protected $keyType = 'int'; 
    public $incrementing = true;


    protected $fillable = [
        'id_akun',
        'tgl_mulai',
        'tgl_berakhir',
        'status',
    ];

    protected $casts = [
        'tgl_mulai' => 'datetime',
        'tgl_berakhir' => 'datetime',
        'status' => 'boolean',
    ];

    public function akun(): BelongsTo
    {
        return $this->belongsTo(AkunUbsc::class, 'id_akun', 'id_akun');
    }

    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_membership');
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_membership');
    }

    public function isActive(): bool
    {
        $today = Carbon::now()->startOfDay();

        return $this->status 
            && $this->tgl_berakhir instanceof Carbon
            && $this->tgl_berakhir->endOfDay()->greaterThanOrEqualTo($today);
    }

    public function daysRemaining(): int
    {
        if (!$this->isActive()) {
            return 0;
        }
        
        return Carbon::now()->diffInDays($this->tgl_berakhir, false) + 1;
    }
}