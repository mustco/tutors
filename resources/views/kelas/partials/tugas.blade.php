{{-- Tombol "Buat Tugas" - Hanya untuk Admin --}}
@if (Auth::check() && Auth::user()->isAdmin())
<div class="bg-green-50 border border-green-300 px-3 py-2 rounded-lg text-gray-700 flex justify-between items-center mb-6">
    <p class="font-semibold">Klik <span class="text-green-600 font-bold">"Buat Tugas"</span> untuk membuat tugas baru.</p>
    <a href="{{ route('kelas.tugas.create', $kelas->kode_kelas) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium">
        Buat Tugas
    </a>
</div>
@endif

<h4 class="text-md font-semibold text-gray-700 mb-2">Daftar Tugas</h4>
<div class="bg-white border border-gray-300 rounded-lg p-4 shadow-sm">
    @if($kelas->tugas->isEmpty())
    <div class="flex flex-col justify-center items-center">
        <div>
            <i class="fa-solid fa-file text-7xl bg-gray-100 p-8 rounded-2xl text-gray-600"></i>
        </div>
        <div class="text-center text-gray-500 pt-4 text-xl font-bold">Tidak ada Tugas apapun</div>
        @if (Auth::check() && Auth::user()->isAdmin())
        <div class="text-center text-gray-500 pb-4">Kamu belum membuat tugas di kelas ini.</div>
        @else
        <div class="text-center text-gray-500 pb-4">Horee, pengajar belum membuat tugas di kelas ini.</div>
        @endif
    </div>
    @else
        @foreach($kelas->tugas as $tugas)
            <div class="border-b border-gray-200 pb-3 mb-3 last:border-b-0 last:pb-0 last:mb-0">
                <h5 class="font-bold text-lg text-gray-800">{{ $tugas->judul_tugas }}</h5>
                <p class="text-gray-600 text-sm">{{ Str::limit($tugas->deskripsi_tugas, 100) }}</p>

                {{-- NEW: Tombol Unduh Lampiran untuk Tugas --}}
                @if($tugas->file_path)
                    <div class="mt-2">
                        <a href="{{ Storage::url($tugas->file_path) }}" target="_blank" class="text-blue-500 hover:underline text-sm flex items-center">
                            <i class="fa-solid fa-file-arrow-down mr-1"></i> Unduh Lampiran
                        </a>
                    </div>
                @endif
                {{-- END NEW --}}

                @if($tugas->deadline)
                    <p class="text- text-gray-500 mt-1">Batas Waktu: {{ $tugas->deadline->format('d M Y, H:i') }}</p>
                    @else
                    <p class="text- text-gray-500 mt-1">Tidak ada Batas Waktu</p>
                @endif

                <div class="mt-2 flex gap-2">
                    <a href="{{ route('kelas.tugas.show', ['kelas' => $kelas->kode_kelas, 'tugas' => $tugas->id]) }}" class="text-blue-500 hover:underline text-sm">Lihat Detail</a>
                    {{-- Tombol Edit dan Hapus Tugas - Hanya untuk Admin --}}
                   
                </div>
            </div>
        @endforeach
    @endif
</div>