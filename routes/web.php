<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\NotifikasiController;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Tugas;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $kelas = collect(); // Inisialisasi koleksi kosong
    $totalTugas = 0; // Inisialisasi total tugas

    if ($user->isAdmin()) {
        // Jika admin, Anda mungkin ingin menampilkan total tugas keseluruhan atau tugas yang dibuat admin
        // Untuk saat ini, kita akan menghitung semua tugas jika admin melihat dashboard
        $kelas = Kelas::withCount('mahasiswas')->get();
        $totalTugas = Tugas::count(); // Atau Tugas::where('admin_id', $user->id)->count(); jika hanya tugas yang dibuatnya
    } else {
        // Jika pengguna adalah mahasiswa, ambil kelas yang diikutinya
        $kelas = $user->kelasAsMahasiswa()->with('tugas')->get(); // Load relasi tugas dari kelas

        // Hitung total tugas dari semua kelas yang diikuti
        foreach ($kelas as $kls) {
            $totalTugas += $kls->tugas->count();
        }
    }

    // Kirimkan $totalTugas ke view dashboard
    return view('dashboard', compact('kelas', 'totalTugas'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('kelas')->name('kelas.')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('index');
        Route::get('/join', [KelasController::class, 'showJoinForm'])->name('join');
        Route::post('/join', [KelasController::class, 'joinClass'])->name('process_join');

        Route::get('/{kelas:kode_kelas}/{section?}', [KelasController::class, 'showSection'])->name('show.section');
        Route::middleware('isAdmin')->group(function () {
            Route::get('/create', [KelasController::class, 'create'])->name('create');
            Route::post('/', [KelasController::class, 'store'])->name('store');
            Route::get('/{kelas:kode_kelas}/edit', [KelasController::class, 'edit'])->name('edit');
            Route::put('/{kelas:kode_kelas}', [KelasController::class, 'update'])->name('update');
            Route::delete('/{kelas:kode_kelas}', [KelasController::class, 'destroy'])->name('destroy');
            Route::post('/{kelas:kode_kelas}/add-mahasiswa', [KelasController::class, 'addMahasiswa'])->name('add_mahasiswa');
            Route::delete('/{kelas:kode_kelas}/remove-mahasiswa/{mahasiswa}', [KelasController::class, 'removeMahasiswa'])->name('remove_mahasiswa');

            Route::get('/{kelas:kode_kelas}/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
            Route::post('/{kelas:kode_kelas}/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
            Route::get('/{kelas:kode_kelas}/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
            Route::put('/{kelas:kode_kelas}/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumuman.update');
            Route::delete('/{kelas:kode_kelas}/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

            Route::get('/{kelas:kode_kelas}/tugas/create', [TugasController::class, 'create'])->name('tugas.create');
            Route::post('/{kelas:kode_kelas}/tugas', [TugasController::class, 'store'])->name('tugas.store');
            Route::get('/{kelas:kode_kelas}/tugas/{tugas}/edit', [TugasController::class, 'edit'])->name('tugas.edit');
            Route::put('/{kelas:kode_kelas}/tugas/{tugas}', [TugasController::class, 'update'])->name('tugas.update');
            Route::delete('/{kelas:kode_kelas}/tugas/{tugas}', [TugasController::class, 'destroy'])->name('tugas.destroy');

            
        });
        Route::post('/{kelas:kode_kelas}/assignment/{tugas}/submit', [TugasController::class, 'submitTugas'])->name('tugas.submit');
        Route::put('/{kelas:kode_kelas}/assignment/{tugas}/submit', [TugasController::class, 'submitTugas'])->name('tugas.update_submit'); // Untuk update via PUT
    
        
        // Modified route for class show with optional tab
        Route::get('/{kelas:kode_kelas}', [KelasController::class, 'show'])->name('show'); // NEW
        // Route::get('/{kelas:kode_kelas}/{tab?}', [KelasController::class, 'show'])->name('show'); // NEW

        Route::get('/{kelas:kode_kelas}/pengumuman/{pengumuman}', [PengumumanController::class, 'show'])->name('pengumuman.show');
        Route::get('/{kelas:kode_kelas}/tugas/{tugas}', [TugasController::class, 'show'])->name('tugas.show');
    });


    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::middleware('isAdmin')->group(function () {
            Route::get('/create', [NotifikasiController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [NotifikasiController::class, 'edit'])->name('edit');
        });
        Route::get('/{id}', [NotifikasiController::class, 'show'])->name('show');
    });
});

require __DIR__.'/auth.php';