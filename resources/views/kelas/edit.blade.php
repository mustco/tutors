<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kelas') . ' - ' . $kelas->nama_kelas }}
        </h2>
    </x-slot>

    <a href="javascript:history.back()" 
   class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 hover:bg-gray-100 hover:shadow-md transition-all duration-200 ease-in-out cursor-pointer group">
    <i class="fa-solid fa-arrow-left text-gray-500 transition-transform duration-300 group-hover:-translate-x-1 group-hover:rotate-[-10deg]"></i>
    <span class="font-medium group-hover:text-gray-900">Kembali</span>
</a>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('kelas.update', $kelas->kode_kelas) }}">
                        @csrf
                        @method('PUT') {{-- PENTING: Untuk mengirim permintaan PUT/PATCH --}}

                        {{-- Nama Kelas --}}
                        <div class="mb-4">
                            <label for="nama_kelas" class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                            <input type="text" name="nama_kelas" id="nama_kelas"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required autofocus>
                            @error('nama_kelas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Nama Dosen --}}
                        <div class="mb-4">
                            <label for="nama_dosen" class="block text-sm font-medium text-gray-700">Nama Dosen</label>
                            <input type="text" name="nama_dosen" id="nama_dosen"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('nama_dosen', $kelas->nama_dosen) }}" required>
                            @error('nama_dosen')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kode Kelas --}}
                        <div class="mb-4">
                            <label for="kode_kelas" class="block text-sm font-medium text-gray-700">Kode Kelas</label>
                            <input type="text" name="kode_kelas" id="kode_kelas"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('kode_kelas', $kelas->kode_kelas) }}" required>
                            <p class="mt-1 text-xs text-gray-500">Kode kelas harus unik (contoh: IF301, PWEB101) 
                            <a href="#" id="generateRandomCode" class="text-blue-600 hover:underline">Generate</a>
                            </p>
                            @error('kode_kelas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >{{ old('deskripsi', $kelas->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Perbarui Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="{{ asset('js/randomGenerate.js') }}"></script>