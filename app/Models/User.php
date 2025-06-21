<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kelasCreatedByAdmin()
    {
        // Parameter kedua 'admin_id' menunjukkan foreign key di tabel 'kelas'
        return $this->hasMany(Kelas::class, 'admin_id');
    }

    public function kelasAsMahasiswa()
    {
        // Parameter kedua 'kelas_mahasiswa' adalah nama tabel pivot
        // Parameter ketiga 'mahasiswa_id' adalah foreign key model ini di tabel pivot
        // Parameter keempat 'kelas_id' adalah foreign key dari model target di tabel pivot
        return $this->belongsToMany(Kelas::class, 'kelas_mahasiswa', 'mahasiswa_id', 'kelas_id')
                    ->withPivot('bergabung_pada') // Jika Anda ingin mengakses kolom tambahan di tabel pivot
                    ->withTimestamps(); // Untuk otomatis mengelola created_at dan updated_at di tabel pivot
    }

    public function tugasCreatedByAdmin()
    {
        return $this->hasMany(Tugas::class, 'admin_id');
    }

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'mahasiswa_id');
    }

    /**
     * Seorang user bisa memiliki banyak notifikasi.
     */
    public function notifications()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }

    // --- Accessor untuk mengecek role ---
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }
}
