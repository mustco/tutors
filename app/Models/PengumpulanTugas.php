<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
    protected $table = 'pengumpulan_tugas'; // Nama tabel jika berbeda dari konvensi

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tugas_id',
        'mahasiswa_id',
        'file_path',
        'nama_file_asli',
        'status',
        'dikumpulkan_pada',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dikumpulkan_pada' => 'datetime',
    ];

    // --- Relasi ---

    /**
     * Sebuah pengumpulan tugas termasuk untuk satu tugas.
     */
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }

    /**
     * Sebuah pengumpulan tugas dibuat oleh satu mahasiswa.
     */
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }
}
