<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Kelas; // Pastikan ini diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     * Biasanya tidak digunakan untuk tugas yang terkait kelas.
     */
    public function index()
    {
        // return Tugas::all();
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

        return redirect()->route('kelas.show', $kelas->kode_kelas)->with('success', 'Tugas berhasil dibuat!');
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
            'deadline_tugas' => 'nullable|date',
        ]);

        $tugas->update([
            'judul_tugas' => $request->judul_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'deadline' => $request->deadline_tugas,
        ]);

        return redirect()->route('kelas.show', $kelas->kode_kelas)->with('success', 'Tugas berhasil diperbarui!');
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
        $tugas->delete(); 

        return redirect()->route('kelas.show', $kelas->kode_kelas)->with('success', 'Tugas berhasil dihapus!');
    }
}