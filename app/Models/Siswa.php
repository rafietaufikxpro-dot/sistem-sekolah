<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'kelas_id',
        'nis',
        'jenis_kelamin',
        'alamat',
        'foto',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo<Kelas, $this>
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * @return HasMany<Nilai, $this>
     */
    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'siswa_id');
    }

    /**
     * @return HasMany<Pengajuan, $this>
     */
    public function pengajuan(): HasMany
    {
        return $this->hasMany(Pengajuan::class, 'siswa_id');
    }
}
