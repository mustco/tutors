<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman'; // Pastikan nama tabel benar

    protected $fillable = [
        'kelas_id',
        'user_id',
        'judul',
        'konten',
        'file_path',
    ];

    // Relasi ke Kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    // Relasi ke User (pembuat pengumuman)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
