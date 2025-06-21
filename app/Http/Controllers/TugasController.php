<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Kelas; // Pastikan ini diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Pastikan ini diimport untuk Storage::delete()
use App\Models\PengumpulanTugas;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     * Biasanya tidak digunakan untuk tugas yang terkait kelas.
     */
    public function index()
    {
        // return Tugas::all(); // Ini mungkin tidak relevan lagi jika tugas hanya dilihat per kelas
    }

    /**
     * Show the form for creating a new resource.
     * Menggunakan Route Model Binding untuk Kelas.
     *
     * @param  \App\Models\Kelas  $kelas
     */
    public function create(Kelas $kelas)
    {
        return view('tugas.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     * Menggunakan Route Model Binding untuk Kelas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     */
    public function store(Request $request, Kelas $kelas)
    {
        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi_tugas' => 'nullable|string',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png|max:10240', // Max 10MB
            'deadline_tugas' => 'nullable|date',
        ]);
        $filePath = null;
        if ($request->hasFile('file_tugas')) {
            // Simpan file ke direktori 'public/tugas_files'
            $filePath = $request->file('file_tugas')->store('tugas_files', 'public');
        }

        $tugas = Tugas::create([
            'judul_tugas' => $request->judul_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'kelas_id' => $kelas->id,
            'admin_id' => Auth::id(),
            'deadline' => $request->deadline_tugas,
            'status' => 'aktif',
            'file_path' => $filePath,
        ]);

        // KOREKSI REDIRECT: Arahkan kembali ke halaman 'tugas' di kelas tersebut
        return redirect()->route('kelas.show.section', ['kelas' => $kelas->kode_kelas, 'section' => 'tugas'])
                         ->with('success', 'Tugas berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     * Menggunakan Route Model Binding untuk Kelas dan Tugas.
     *
     * @param  \App\Models\Kelas  $kelas
     * @param  \App\Models\Tugas  $tugas
     */
    public function show(Kelas $kelas, Tugas $tugas)
    {
        if ($tugas->kelas_id !== $kelas->id) {
            abort(404);
        }

        // NEW: Load the current user's submission for this task OR all submissions if admin
        if (Auth::user()->isAdmin()) {
            // Jika admin, load semua pengumpulan tugas untuk tugas ini
            $tugas->load('pengumpulanMahasiswas.mahasiswa'); // Load juga relasi mahasiswa dari pengumpulan
        } else {
            // Jika mahasiswa, load pengumpulan tugas milik sendiri
            $tugas->load(['pengumpulanMahasiswas' => function($query) {
                $query->where('mahasiswa_id', Auth::id());
            }]);
        }

        return view('tugas.show', compact('kelas', 'tugas'));
    
    }


    /**
     * Show the form for editing the specified resource.
     * Menggunakan Route Model Binding untuk Kelas dan Tugas.
     *
     * @param  \App\Models\Kelas  $kelas
     * @param  \App\Models\Tugas  $tugas
     */
    public function edit(Kelas $kelas, Tugas $tugas)
    {
        if ($tugas->kelas_id !== $kelas->id) {
            abort(404);
        }
        return view('tugas.edit', compact('kelas', 'tugas'));
    }

    /**
     * Update the specified resource in storage.
     * Menggunakan Route Model Binding untuk Kelas dan Tugas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @param  \App\Models\Tugas  $tugas
     */
    public function update(Request $request, Kelas $kelas, Tugas $tugas)
    {
        if ($tugas->kelas_id !== $kelas->id) {
            abort(404);
        }
        $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi_tugas' => 'nullable|string',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png|max:10240', // Max 10MB
            'deadline_tugas' => 'nullable|date',
        ]);

        // Handle file update
        $filePath = $tugas->file_path; // Keep old file path by default
        if ($request->hasFile('file_tugas')) {
            // Delete old file if exists
            if ($tugas->file_path) {
                Storage::disk('public')->delete($tugas->file_path);
            }
            $filePath = $request->file('file_tugas')->store('tugas_files', 'public');
        } elseif ($request->input('clear_file')) { // Add a hidden field to clear file
            if ($tugas->file_path) {
                Storage::disk('public')->delete($tugas->file_path);
            }
            $filePath = null;
        }

        $tugas->update([
            'judul_tugas' => $request->judul_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'deadline' => $request->deadline_tugas,
            'file_path' => $filePath, // Update file path
        ]);

        // KOREKSI REDIRECT: Arahkan kembali ke halaman 'tugas' di kelas tersebut
        return redirect()->route('kelas.show.section', ['kelas' => $kelas->kode_kelas, 'section' => 'tugas'])
                         ->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menggunakan Route Model Binding untuk Kelas dan Tugas.
     *
     * @param  \App\Models\Kelas  $kelas
     * @param  \App\Models\Tugas  $tugas
     */
    public function destroy(Kelas $kelas, Tugas $tugas)
    {
        if ($tugas->kelas_id !== $kelas->id) {
            abort(404);
        }
        // Delete associated file if exists
        if ($tugas->file_path) {
            Storage::disk('public')->delete($tugas->file_path);
        }
        $tugas->delete();

        // KOREKSI REDIRECT: Arahkan kembali ke halaman 'tugas' di kelas tersebut
        return redirect()->route('kelas.show.section', ['kelas' => $kelas->kode_kelas, 'section' => 'tugas'])
                         ->with('success', 'Tugas berhasil dihapus!');
    }


    public function submitTugas(Request $request, Kelas $kelas, Tugas $tugas)
    {
       // Pastikan hanya mahasiswa yang bisa mengumpulkan tugas
       if (Auth::user()->isAdmin()) {
        return redirect()->back()->with('error', 'Hanya mahasiswa yang dapat mengumpulkan tugas.');
    }

    // Pastikan tugas milik kelas ini
    if ($tugas->kelas_id !== $kelas->id) {
        abort(404);
    }

    // --- VALIDASI DEADLINE (BARU DITAMBAHKAN) ---
    // Jika tugas memiliki deadline DAN waktu saat ini sudah melewati deadline
    if ($tugas->deadline && now()->greaterThan($tugas->deadline)) {
        return redirect()->back()->with('error', 'Pengumpulan Gagal: Tugas ini sudah melewati batas waktu pengumpulan.');
    }
    // --- AKHIR VALIDASI DEADLINE ---

    $request->validate([
        'file_pengumpulan' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,jpg,jpeg,png|max:10240', // Max 10MB
    ]);

    $mahasiswaId = Auth::id();

    // Cari apakah mahasiswa ini sudah pernah mengumpulkan tugas ini sebelumnya
    $pengumpulan = PengumpulanTugas::where('tugas_id', $tugas->id)
                                   ->where('mahasiswa_id', $mahasiswaId)
                                   ->first();

    $filePath = null;
    $originalFileName = $request->file('file_pengumpulan')->getClientOriginalName();

    if ($request->hasFile('file_pengumpulan')) {
        // Jika ada file pengumpulan lama, hapus dulu
        if ($pengumpulan && $pengumpulan->file_path) {
            Storage::disk('public')->delete($pengumpulan->file_path);
        }
        // Simpan file baru
        $filePath = $request->file('file_pengumpulan')->store('pengumpulan_tugas_files', 'public');
    }

    if ($pengumpulan) {
        // Update pengumpulan yang sudah ada
        $pengumpulan->update([
            'file_path' => $filePath,
            'nama_file_asli' => $originalFileName,
            'status' => 'dikumpulkan', // Bisa juga 'draft' jika ingin ada tahap draft
            'dikumpulkan_pada' => now(),
        ]);
        $message = 'Pengumpulan tugas berhasil diperbarui!';
    } else {
        // Buat pengumpulan baru
        PengumpulanTugas::create([
            'tugas_id' => $tugas->id,
            'mahasiswa_id' => $mahasiswaId,
            'file_path' => $filePath,
            'nama_file_asli' => $originalFileName,
            'status' => 'dikumpulkan',
            'dikumpulkan_pada' => now(),
        ]);
        $message = 'Tugas berhasil dikumpulkan!';
    }

    return redirect()->route('kelas.tugas.show', ['kelas' => $kelas->kode_kelas, 'tugas' => $tugas->id])
                     ->with('success', $message);
}
    }

