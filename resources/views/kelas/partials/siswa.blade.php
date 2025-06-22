{{-- Bagian "Tambah Siswa ke Kelas" - Hanya untuk Admin --}}
@if (Auth::check() && Auth::user()->isAdmin())
<div class="bg-white border border-gray-300 rounded-lg p-4 shadow-sm mb-6">
    <h4 class="text-md font-semibold text-gray-700 mb-2">Tambah Siswa ke Kelas</h4>
    <p class="text-gray-600 text-sm mb-3">Bagikan kode kelas ini agar siswa bisa bergabung: <span class="font-bold text-blue-600">{{ $kelas->kode_kelas }}</span></p>

    <form action="{{ route('kelas.add_mahasiswa', $kelas->kode_kelas) }}" method="POST">
        @csrf
        <label for="mahasiswa_email" class="block text-sm font-medium text-gray-700">Email Mahasiswa (Opsional):</label>
        <input type="email" name="mahasiswa_email" id="mahasiswa_email" placeholder="contoh: siswa@example.com"
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mb-3" required>
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