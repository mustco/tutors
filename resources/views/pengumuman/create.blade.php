<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengumuman Baru di Kelas: ') . $kelas->nama_kelas }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('kelas.pengumuman.store', $kelas->kode_kelas) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="judul_pengumuman" class="block text-sm font-medium text-gray-700">Judul Pengumuman</label>
                            <input type="text" name="judul_pengumuman" id="judul_pengumuman"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Berikan Pengumuman untuk" value="{{ old('judul_pengumuman') }}" required autofocus>
                            @error('judul_pengumuman')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="target_siswa" class="block text-sm font-medium text-gray-700">Target Siswa</label>
                            <select name="target_siswa" id="target_siswa"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="all">Semua Siswa</option>
                                {{-- Jika Anda ingin daftar siswa spesifik, Anda harus pass data $kelas->mahasiswas dari controller --}}
                                {{-- @foreach($kelas->mahasiswas as $mahasiswa)
                                    <option value="{{ $mahasiswa->id }}">{{ $mahasiswa->name }}</option>
                                @endforeach --}}
                            </select>
                            @error('target_siswa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="konten_pengumuman" class="block text-sm font-medium text-gray-700">Konten Pengumuman</label>
                            <textarea name="konten_pengumuman" id="konten_pengumuman" rows="6" placeholder="Umumkan informasi apapun ke kelasmu"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >{{ old('konten_pengumuman') }}</textarea>
                            @error('konten_pengumuman')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                       
                        <div class="mb-6">
                        <label for="file_upload" class="block text-sm font-medium text-gray-700">Lampirkan File (Opsional)</label>
                        <input type="file" name="file_upload" id="file_upload"
                               class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-md file:border-0
                               file:text-sm file:font-semibold
                               file:bg-blue-50 file:text-blue-700
                               hover:file:bg-blue-100" />
                        @error('file_upload')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('kelas.show', $kelas->kode_kelas) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Posting Pengumuman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>