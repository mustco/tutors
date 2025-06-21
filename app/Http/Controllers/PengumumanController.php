<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use App\Models\Kelas; // Pastikan ini diimport
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Pastikan ini diimport

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     
    }

    /**
     * Show the form for creating a new resource.
     * Menggunakan Route Model Binding untuk Kelas.
     *
     * @param  \App\Models\Kelas  $kelas
     */
    public function create(Kelas $kelas)
    {
        return view('pengumuman.create', compact('kelas'));
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
            'judul_pengumuman' => 'required|string|max:255',
            'konten_pengumuman' => 'nullable|string',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('file_upload')) {
            // Simpan file ke storage (misal: storage/app/public/pengumuman_files)
            $filePath = $request->file('file_upload')->store('pengumuman_files', 'public');
        }

        Pengumuman::create([
            'kelas_id' => $kelas->id,
            'user_id' => Auth::id(), 
            'judul' => $request->judul_pengumuman,
            'konten' => $request->konten_pengumuman,
            'file_path' => $filePath,
        ]);

        return redirect()->route('kelas.show', $kelas->kode_kelas)->with('success', 'Pengumuman berhasil diposting!');
    }

    /**
     * Display the specified resource.
     * Menggunakan Route Model Binding untuk Kelas dan Pengumuman.
     *
     * @param  \App\Models\Kelas  $kelas
     * @param  \App\Models\Pengumuman  $pengumuman
     */
    public function show(Kelas $kelas, Pengumuman $pengumuman)
    {
        if ($pengumuman->kelas_id !== $kelas->id) {
            abort(404); 
        }
        return view('pengumuman.show', compact('kelas', 'pengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     * Menggunakan Route Model Binding untuk Kelas dan Pengumuman.
     *
     * @param  \App\Models\Kelas  $kelas
     * @param  \App\Models\Pengumuman  $pengumuman
     */
    public function edit(Kelas $kelas, Pengumuman $pengumuman)
    {
        if ($pengumuman->kelas_id !== $kelas->id) {
            abort(404);
        }
        return view('pengumuman.edit', compact('kelas', 'pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     * Menggunakan Route Model Binding untuk Kelas dan Pengumuman.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @param  \App\Models\Pengumuman  $pengumuman
     */
    public function update(Request $request, Kelas $kelas, Pengumuman $pengumuman)
    {
        if ($pengumuman->kelas_id !== $kelas->id) {
            abort(404);
        }
        $request->validate([
            'judul_pengumuman' => 'required|string|max:255',
            'konten_pengumuman' => 'nullable|string',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file_upload')) {
            // Hapus file lama jika ada
            if ($pengumuman->file_path) {
                Storage::disk('public')->delete($pengumuman->file_path);
            }
            $filePath = $request->file('file_upload')->store('pengumuman_files', 'public');
        } else {
            $filePath = $pengumuman->file_path; 
        }

        $pengumuman->update([
            'judul' => $request->judul_pengumuman,
            'konten' => $request->konten_pengumuman,
            'file_path' => $filePath,
        ]);

        return redirect()->route('kelas.show', $kelas->kode_kelas)->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menggunakan Route Model Binding untuk Kelas dan Pengumuman.
     *
     * @param  \App\Models\Kelas  $kelas
     * @param  \App\Models\Pengumuman  $pengumuman
     */
    public function destroy(Kelas $kelas, Pengumuman $pengumuman)
    {
        if ($pengumuman->kelas_id !== $kelas->id) {
            abort(404);
        }
        if ($pengumuman->file_path) {
            Storage::disk('public')->delete($pengumuman->file_path);
        }
        $pengumuman->delete();

        return redirect()->route('kelas.show', $kelas->kode_kelas)->with('success', 'Pengumuman berhasil dihapus!');
    }
}