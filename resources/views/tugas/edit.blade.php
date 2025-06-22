<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tugas') }}
        </h2>
    </x-slot>

    <a href="javascript:history.back()" 
   class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 hover:bg-gray-100 hover:shadow-md transition-all duration-200 ease-in-out cursor-pointer group">
    <i class="fa-solid fa-arrow-left text-gray-500 transition-transform duration-300 group-hover:-translate-x-1 group-hover:rotate-[-10deg]"></i>
    <span class="font-medium group-hover:text-gray-900">Kembali</span>
</a>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Tugas: "{{ $tugas->judul_tugas }}"</h1>

                    <form action="{{ route('kelas.tugas.update', ['kelas' => $kelas->kode_kelas, 'tugas' => $tugas->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Gunakan method PUT untuk update --}}

                        <div class="mb-4">
                            <label for="judul_tugas" class="block text-sm font-medium text-gray-700">Judul Tugas <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_tugas" id="judul_tugas" value="{{ old('judul_tugas', $tugas->judul_tugas) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            @error('judul_tugas')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi_tugas" class="block text-sm font-medium text-gray-700">Deskripsi Tugas</label>
                            <textarea name="deskripsi_tugas" id="deskripsi_tugas" rows="5"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('deskripsi_tugas', $tugas->deskripsi_tugas) }}</textarea>
                            @error('deskripsi_tugas')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="file_tugas" class="block text-sm font-medium text-gray-700">Lampiran Tugas (Opsional)</label>
                            <input type="file" name="file_tugas" id="file_tugas"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="text-xs text-gray-500 mt-1">Maksimal 10MB (PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR, JPG, JPEG, PNG)</p>
                            @error('file_tugas')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            @if($tugas->file_path)
                                <div class="mt-2 flex items-center text-sm text-gray-600">
                                    File saat ini: <a href="{{ Storage::url($tugas->file_path) }}" target="_blank" class="text-blue-500 hover:underline ml-1 mr-3"><i class="fa-solid fa-file-arrow-down mr-1"></i> {{ basename($tugas->file_path) }}</a>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="clear_file" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-gray-700">Hapus file saat ini</span>
                                    </label>
                                </div>
                            @endif
                        </div>

                        <div class="mb-6">
                            <label for="deadline_tugas" class="block text-sm font-medium text-gray-700">Batas Waktu (Opsional)</label>
                            <input type="datetime-local" name="deadline_tugas" id="deadline_tugas" value="{{ old('deadline_tugas', $tugas->deadline ? $tugas->deadline->format('Y-m-d\TH:i') : '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @error('deadline_tugas')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Perbarui Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>