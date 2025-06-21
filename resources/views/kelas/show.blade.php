<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden border shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Alert Messages --}}
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif
                    @if (session('info'))
                        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('info') }}</span>
                        </div>
                    @endif
                    {{-- End Alert Messages --}}

                    {{-- Judul Kelas dan Dosen --}}
                    <h1 class="text-2xl font-bold text-gray-800">{{ $kelas->nama_kelas }}</h1>
                    <p class="text-gray-600 mb-6">{{ $kelas->nama_dosen }}</p>

                    {{-- Navigation Tabs --}}
                    <div x-data="{
                        currentTab: window.location.hash.substring(1) || 'forum', // Baca hash dari URL, default 'forum'
                        setActiveTab(tab) {
                            this.currentTab = tab;
                            window.location.hash = tab; // Set hash di URL
                        }
                    }"
                    x-init="
                        // Opsional: Dengarkan perubahan hash di URL (misal dari back/forward browser)
                        window.addEventListener('hashchange', () => {
                            if (this.currentTab !== window.location.hash.substring(1)) {
                                this.currentTab = window.location.hash.substring(1);
                            }
                        });
                        // Pastikan ada hash jika tidak ada, default ke forum
                        if (!window.location.hash) {
                            window.location.hash = 'forum';
                        }
                    "
                    class="mb-6">
                        <div class="flex border-b pb-2 border-gray-200 space-x-5">
                            <a @click="setActiveTab('forum')" :class="{ 'border-2 bg-[#3F4D67] border-gray-600 text-white': currentTab === 'forum', 'border border-gray-600 text-gray-800 hover:text-gray-900 hover:bg-gray-100': currentTab !== 'forum' }"
                                class="rounded-md py-2 px-10 text-center font-medium focus:outline-none transition-colors duration-200 cursor-pointer">
                                Forum
                            </a>
                            <a @click="setActiveTab('tugas')" :class="{ 'border-2 bg-[#3F4D67] border-gray-600 text-white': currentTab === 'tugas', 'border border-gray-600 text-gray-800 hover:text-gray-900 hover:bg-gray-100': currentTab !== 'tugas' }"
                                class="rounded-md py-2 px-10 text-center font-medium focus:outline-none transition-colors duration-200 cursor-pointer">
                                Tugas
                            </a>
                            <a @click="setActiveTab('siswa')" :class="{ 'border-2 bg-[#3F4D67] border-gray-600 text-white': currentTab === 'siswa', 'border border-gray-600 text-gray-800 hover:text-gray-900 hover:bg-gray-100': currentTab !== 'siswa' }"
                                class="rounded-md py-2 px-10 text-center font-medium focus:outline-none transition-colors duration-200 cursor-pointer">
                                Siswa
                            </a>
                        </div>

                        {{-- Tab Content (menggunakan Alpine.js x-show) --}}
                        <div class="mt-4">
                            {{-- Forum Tab Content --}}
                            <div x-show="currentTab === 'forum'">
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
                            </div>

                            {{-- Tugas Tab Content --}}
                            <div x-show="currentTab === 'tugas'">
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
                                                @endif
                                                <div class="mt-2 flex gap-2">
                                                    <a href="{{ route('kelas.tugas.show', ['kelas' => $kelas->kode_kelas, 'tugas' => $tugas->id]) }}" class="text-blue-500 hover:underline text-sm">Lihat Detail</a>
                                                    {{-- Tombol Edit dan Hapus Tugas - Hanya untuk Admin --}}
                                                    @if (Auth::check() && Auth::user()->isAdmin())
                                                    <a href="{{ route('kelas.tugas.edit', ['kelas' => $kelas->kode_kelas, 'tugas' => $tugas->id]) }}" class="text-yellow-500 hover:underline text-sm">Edit</a>
                                                    <form action="{{ route('kelas.tugas.destroy', ['kelas' => $kelas->kode_kelas, 'tugas' => $tugas->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:underline text-sm">Hapus</button>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            {{-- Siswa Tab Content --}}
                            <div x-show="currentTab === 'siswa'">
                                {{-- Bagian "Tambah Siswa ke Kelas" - Hanya untuk Admin --}}
                                @if (Auth::check() && Auth::user()->isAdmin())
                                <div class="bg-white border border-gray-300 rounded-lg p-4 shadow-sm mb-6">
                                    <h4 class="text-md font-semibold text-gray-700 mb-2">Tambah Siswa ke Kelas</h4>
                                    <p class="text-gray-600 text-sm mb-3">Bagikan kode kelas ini agar siswa bisa bergabung: <span class="font-bold text-blue-600">{{ $kelas->kode_kelas }}</span></p>

                                    <form action="{{ route('kelas.add_mahasiswa', $kelas->kode_kelas) }}" method="POST">
                                        @csrf
                                        <label for="mahasiswa_email" class="block text-sm font-medium text-gray-700">Email Mahasiswa (Opsional):</label>
                                        <input type="email" name="mahasiswa_email" id="mahasiswa_email" placeholder="contoh: siswa@example.com"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mb-3">
                                        <p class="mt-1 text-sm italic text-gray-500">Atau biarkan siswa bergabung dengan kode kelas.</p>

                                        <div class="flex justify-end items-center mt-4">
                                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">Undang Siswa</button>
                                        </div>
                                    </form>
                                </div>
                                @endif

                                <h4 class="text-md font-semibold text-gray-700 mb-2">Daftar Siswa</h4>
                                <div class="bg-white border border-gray-300 rounded-lg p-4 shadow-sm">
                                    @if($kelas->mahasiswas->isEmpty())
                                    <div class="flex flex-col justify-center items-center">
                                        <div>
                                            <i class="fa-solid fa-users text-7xl bg-gray-100 py-8 px-7 rounded-full text-gray-600"></i>
                                        </div>
                                        <div class="text-center text-gray-500 py-4">Belum ada siswa yang bergabung di kelas ini.</div>
                                    </div>
                                    @else
                                        @foreach($kelas->mahasiswas as $mahasiswa)
                                            <div class="flex items-center justify-between border-b border-gray-200 pb-2 mb-2 last:border-b-0 last:pb-0 last:mb-0">
                                                <p class="text-gray-800 font-medium">
                                                    {{ $mahasiswa->name }}
                                                    @if (Auth::check()) {{-- Pastikan pengguna login --}}
                                                        @if (Auth::user()->isAdmin() || Auth::user()->id === $mahasiswa->id)
                                                            {{-- Admin bisa melihat semua email, atau pengguna bisa melihat emailnya sendiri --}}
                                                            <span class="text-sm text-gray-500">({{ $mahasiswa->email }})</span>
                                                        @endif
                                                    @endif
                                                    <span>{{ $mahasiswa->id === Auth::user()->id ? '(Anda)' : '' }}</span>
                                                </p>
                                                {{-- Tombol "Keluarkan" Siswa - Hanya untuk Admin --}}
                                                @if (Auth::check() && Auth::user()->isAdmin())
                                                <form action="{{ route('kelas.remove_mahasiswa', ['kelas' => $kelas->kode_kelas, 'mahasiswa' => $mahasiswa->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan siswa ini dari kelas?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:underline text-sm">Keluarkan</button>
                                                </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>