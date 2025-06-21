<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'nama_dosen',
        'kode_kelas',
        'deskripsi',
        'admin_id',
    ];

    public function admin()
    {
        // Parameter kedua 'admin_id' menunjukkan foreign key di tabel 'kelas' yang merujuk ke tabel 'users'
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Sebuah kelas bisa memiliki banyak mahasiswa.
     * Ini adalah relasi Many-to-Many melalui tabel pivot 'kelas_mahasiswa'.
     */
    public function mahasiswas()
    {
        // Parameter kedua 'kelas_mahasiswa' adalah nama tabel pivot
        // Parameter ketiga 'kelas_id' adalah foreign key model ini di tabel pivot
        // Parameter keempat 'mahasiswa_id' adalah foreign key dari model target di tabel pivot
        return $this->belongsToMany(User::class, 'kelas_mahasiswa', 'kelas_id', 'mahasiswa_id')
                    ->withPivot('bergabung_pada')
                    ->withTimestamps();
    }

 
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kelas_id');
    }
    public function pengumuman()
    {
        return $this->hasMany(Pengumuman::class, 'kelas_id');
    }
}
