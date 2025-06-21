<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user(); 

        if ($user->isAdmin()) {
            // Jika pengguna adalah admin, tampilkan semua kelas
            $kelas = Kelas::withCount('mahasiswas')->get();
        } else {
            $kelas = $user->kelasAsMahasiswa()->withCount('mahasiswas')->get();
        }

        return view('kelas.index', compact('kelas'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'nama_dosen' => 'required|string|max:255',
            'kode_kelas' => 'required|string|unique:kelas|max:255',
            'deskripsi' => 'nullable|string',
        ]);
        
        $kelas = Kelas::create([ 
            'nama_kelas' => $request->nama_kelas,
            'nama_dosen' => $request->nama_dosen,
            'kode_kelas' => $request->kode_kelas,
            'deskripsi' => $request->deskripsi,
            'admin_id' => Auth::id(), 
        ]);

        return redirect()->route('kelas.index', $kelas->kode_kelas)->with('success', 'Kelas berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     * Menggunakan Route Model Binding dengan custom key 'kode_kelas'.
     *
     * @param  \App\Models\Kelas  $kelas
     */
    public function show(Kelas $kelas)
    {
        $kelas->load([
            'admin',
            'pengumuman' => function($query) {
                $query->orderByDesc('created_at')->with('user'); 
            },
            'tugas' => function($query) {
                $query->orderByDesc('created_at'); 
            },
            'mahasiswas' 
        ]);
        
        return view('kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menggunakan Route Model Binding dengan custom key 'kode_kelas'.
     *
     * @param  \App\Models\Kelas  $kelas
     */
    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     */
    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'nama_dosen' => 'required|string|max:255',
            'kode_kelas' => 'required|string|max:255|unique:kelas,kode_kelas,' . $kelas->id,
            'deskripsi' => 'nullable|string',
        ]);
        
        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'nama_dosen' => $request->nama_dosen,
            'kode_kelas' => $request->kode_kelas,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kelas.show', $kelas->kode_kelas)->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menggunakan Route Model Binding dengan custom key 'kode_kelas'.
     *
     * @param  \App\Models\Kelas  $kelas
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }

    /**
     * Tambahkan mahasiswa ke kelas menggunakan email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     */
    public function addMahasiswa(Request $request, Kelas $kelas)
    {
        $request->validate([
            'mahasiswa_email' => 'nullable|email|exists:users,email',
        ]);

        if ($request->filled('mahasiswa_email')) {
            $mahasiswa = User::where('email', $request->mahasiswa_email)->first();

            if ($mahasiswa) {
                if ($mahasiswa->role !== 'mahasiswa') {
                    return redirect()->route('kelas.show', $kelas->kode_kelas)->with('error', 'User ini bukan Mahasiswa. Hanya Mahasiswa yang dapat ditambahkan.');
                }
                if (!$kelas->mahasiswas()->where('mahasiswa_id', $mahasiswa->id)->exists()) {
                    $kelas->mahasiswas()->attach($mahasiswa->id, ['bergabung_pada' => now()]);
                    return redirect()->route('kelas.show', $kelas->kode_kelas)->with('success', 'Mahasiswa berhasil ditambahkan!');
                } else {
                    return redirect()->route('kelas.show', $kelas->kode_kelas)->with('error', 'Mahasiswa sudah terdaftar di kelas ini.');
                }
            }
        }
        return redirect()->route('kelas.show', $kelas->kode_kelas)->with('info', 'Tidak ada mahasiswa yang ditambahkan secara langsung. Siswa dapat bergabung menggunakan kode kelas ini.');
    }

    /**
     * Keluarkan mahasiswa dari kelas.
     *
     * @param  \App\Models\Kelas  $kelas
     * @param  \App\Models\User  $mahasiswa
     */
    public function removeMahasiswa(Kelas $kelas, User $mahasiswa)
    {
        if ($mahasiswa->role !== 'mahasiswa') {
            return redirect()->route('kelas.show', $kelas->kode_kelas)->with('error', 'User ini bukan Mahasiswa.');
        }

        $kelas->mahasiswas()->detach($mahasiswa->id);

        return redirect()->route('kelas.show', $kelas->kode_kelas)->with('success', 'Mahasiswa berhasil dikeluarkan dari kelas.');
    }

    public function showJoinForm()
    {
        return view('kelas.join'); 
    }

    public function joinClass(Request $request)
    {
        $request->validate([
            'kode_kelas' => ['required', 'string', 'exists:kelas,kode_kelas'],
        ], [
            'kode_kelas.exists' => 'Kode kelas tidak valid atau tidak ditemukan.',
        ]);

        $kelas = Kelas::where('kode_kelas', $request->kode_kelas)->first();
        $user = Auth::user();

        // Cek apakah pengguna sudah terdaftar di kelas ini
        if ($kelas->mahasiswas->contains($user->id)) {
            return redirect()->route('kelas.show', $kelas->kode_kelas)->with('info', 'Anda sudah bergabung di kelas ini.');
        }

        // Tambahkan pengguna ke kelas
        // Asumsi relasi many-to-many antara Kelas dan User (mahasiswas)
        $kelas->mahasiswas()->attach($user->id);

        return redirect()->route('kelas.show', $kelas->kode_kelas)->with('success', 'Berhasil bergabung dengan kelas!');
    }

}