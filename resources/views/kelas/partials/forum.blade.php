{{-- Area untuk membuat pengumuman (ganti dengan tombol) - Hanya untuk Admin --}}
@if (Auth::check() && Auth::user()->isAdmin())
<div class="bg-blue-50 border border-blue-200 px-3 py-2 rounded-lg text-gray-700 flex justify-between items-center mb-6">
    <p class="font-semibold">Klik <span class="text-blue-600 font-bold">"Buat Pengumuman"</span> untuk membuat pengumuman baru.</p>
    <a href="{{ route('kelas.pengumuman.create', $kelas->kode_kelas) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
        Buat Pengumuman
    </a>
</div>
@endif

{{-- Placeholder untuk Daftar Pengumuman --}}
<h4 class="text-md font-semibold text-gray-700 mb-2">Daftar Pengumuman</h4>
<div class="bg-white border border-blue-300 rounded-lg p-4 shadow-sm">
    @if($kelas->pengumuman->isEmpty())
    <div class="flex flex-col justify-center items-center">
        <div>
            <i class="fa-solid fa-bullhorn text-7xl bg-gray-100 p-8 rounded-full text-gray-600"></i>
        </div>
        <div class="text-center text-gray-500 pt-4 text-xl font-bold">Tidak ada Pengumuman apapun</div>
        @if (Auth::check() && Auth::user()->isAdmin())
        <div class="text-center text-gray-500 pb-4">Kamu belum membuat pengumuman di kelas ini.</div>
        @else
        <div class="text-center text-gray-500 pb-4">Horee, pengajar belum membuat pengumuman di kelas ini.</div>
        @endif
    </div>
    @else
        @foreach($kelas->pengumuman as $pengumuman)
            <div class="border-b border-blue-300 pb-3 mb-3 last:border-b-0 last:pb-0 last:mb-0">
                <h5 class="font-bold text-lg text-gray-800">{{ $pengumuman->judul }}</h5>
                <p class="text-gray-600 text-md">{{ $pengumuman->konten }}</p>
                @if($pengumuman->file_path)
                    <a href="{{ Storage::url($pengumuman->file_path) }}" target="_blank" class="text-blue-500 hover:underline text-sm"><i class="fa-solid fa-file-arrow-down mr-1"></i> Unduh Lampiran</a>
                @endif
                <p class="text-sm text-gray-500 mt-1">Pengumuman baru oleh {{ $kelas->nama_dosen }} pada {{ $pengumuman->created_at->format('d M Y, H:i') }}</p>
            </div>
        @endforeach
    @endif
</div>