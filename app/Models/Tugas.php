<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $fillable = [
        'judul_tugas',
        'deskripsi_tugas',
        'kelas_id',
        'admin_id',
        'deadline',
        'status',
        'file_path',
    ];
     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deadline' => 'datetime',
    ];

    // --- Relasi ---

    /**
     * Sebuah tugas termasuk dalam satu kelas.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Sebuah tugas dibuat oleh satu admin.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Sebuah tugas bisa memiliki banyak pengumpulan tugas.
     */
    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'tugas_id');
    }
}
