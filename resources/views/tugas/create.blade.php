<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Tugas Baru di Kelas: ') . $kelas->nama_kelas }}
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
                    <form method="POST" action="{{ route('kelas.tugas.store', $kelas->kode_kelas) }}"  enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="judul_tugas" class="block text-sm font-medium text-gray-700">Judul Tugas</label>
                            <input type="text" name="judul_tugas" id="judul_tugas"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Judul Tugas" value="{{ old('judul_tugas') }}" required autofocus>
                            @error('judul_tugas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi_tugas" class="block text-sm font-medium text-gray-700">Deskripsi Tugas (Opsional)</label>
                            <textarea name="deskripsi_tugas" id="deskripsi_tugas" rows="6" placeholder="Deskripsi Tugas"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >{{ old('deskripsi_tugas') }}</textarea>
                            @error('deskripsi_tugas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                        <label for="file_tugas" class="block text-sm font-medium text-gray-700">Lampirkan File (Opsional)</label>
                        <input type="file" name="file_tugas" id="file_tugas"
                               class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-md file:border-0
                               file:text-sm file:font-semibold
                               file:bg-blue-50 file:text-blue-700
                               hover:file:bg-blue-100" />
                        @error('file_tugas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        </div>
                        <div class="mb-6">
                            <label for="deadline_tugas" class="block text-sm font-medium text-gray-700">Batas Waktu (Opsional)</label>
                            <input type="datetime-local" name="deadline_tugas" id="deadline_tugas"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('deadline_tugas') }}">
                            @error('deadline_tugas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Buat Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>