<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'guru';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nip',
        'mapel',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasOne<Kelas, $this>
     */
    public function kelas(): HasOne
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');
    }

    /**
     * @return HasMany<Nilai, $this>
     */
    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'guru_id');
    }

    /**
     * @return HasMany<Pengajuan, $this>
     */
    public function pengajuan(): HasMany
    {
        return $this->hasMany(Pengajuan::class, 'guru_id');
    }
}
