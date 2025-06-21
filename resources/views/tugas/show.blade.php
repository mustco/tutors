<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tugas') }}
        </h2>
    </x-slot>

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

                    <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $tugas->judul_tugas }}</h1>
                    <p class="text-gray-600 mb-4">Untuk Kelas: <a href="{{ route('kelas.show.section', ['kelas' => $kelas->kode_kelas, 'section' => 'tugas']) }}" class="text-blue-600 hover:underline">{{ $kelas->nama_kelas }}</a></p>

                    <div class="border-t border-gray-200 pt-4">
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Deskripsi Tugas:</h3>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            {{ $tugas->deskripsi_tugas }}
                        </p>

                        @if($tugas->file_path)
                            <div class="mb-4">
                                <span class="font-semibold text-gray-700">Lampiran Tugas:</span>
                                <a href="{{ Storage::url($tugas->file_path) }}" target="_blank" class="text-blue-500 hover:underline flex items-center mt-1">
                                    <i class="fa-solid fa-file-arrow-down mr-2"></i> Unduh Lampiran Tugas
                                </a>
                            </div>
                        @endif

                        @if($tugas->deadline)
                            <div class="mb-4">
                                <span class="font-semibold text-gray-700">Batas Waktu Pengumpulan:</span>
                                <p class="text-gray-700">{{ $tugas->deadline->format('d M Y, H:i') }}</p>
                                @if (now()->greaterThan($tugas->deadline))
                                    <p class="text-red-500 text-sm font-semibold">Tugas ini sudah melewati batas waktu pengumpulan!</p>
                                @endif
                            </div>
                        @else
                             <div class="mb-4">
                                 <span class="font-semibold text-gray-700">Batas Waktu Pengumpulan:</span>
                                 <p class="text-gray-700">Tidak ada batas waktu.</p>
                             </div>
                        @endif

                        <div class="text-sm text-gray-500 mt-6">
                            Dibuat pada: {{ $tugas->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    {{-- Bagian Pengumpulan Tugas untuk Mahasiswa --}}
                    @if (Auth::check() && !Auth::user()->isAdmin())
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <h3 class="text-xl font-semibold text-gray-700 mb-4">Pengumpulan Anda:</h3>
                            @php
                                $pengumpulan = $tugas->pengumpulanMahasiswas->where('mahasiswa_id', Auth::id())->first();
                            @endphp

                            <form action="{{ $pengumpulan ? route('kelas.tugas.update_submit', ['kelas' => $kelas->kode_kelas, 'tugas' => $tugas->id]) : route('kelas.tugas.submit', ['kelas' => $kelas->kode_kelas, 'tugas' => $tugas->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                @if($pengumpulan)
                                    @method('PUT') {{-- Gunakan PUT jika sudah ada pengumpulan untuk update --}}
                                @endif

                                <div class="mb-4">
                                    <label for="file_pengumpulan" class="block text-sm font-medium text-gray-700">File Pengumpulan Anda <span class="text-red-500">*</span></label>
                                    @if (now()->greaterThan($tugas->deadline))
                                    <p class="text-red-500 text-sm font-semibold">Tugas ini sudah melewati batas waktu pengumpulan!</p>
    <input type="file" name="file_pengumpulan" id="file_pengumpulan"
        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700"
        disabled> {{-- Tambahkan disabled di sini --}}
                                    @else
                                    <input type="file" name="file_pengumpulan" id="file_pengumpulan"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        @if(!$pengumpulan) required @endif> {{-- Required hanya jika belum ada pengumpulan --}}
                                    <p class="text-xs text-gray-500 mt-1">Format yang diizinkan: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR, JPG, JPEG, PNG (Maks 10MB)</p>
                                    @error('file_pengumpulan')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                @endif
                                </div>

                                @if($pengumpulan)
                                    <div class="mt-2 mb-4">
                                        <p class="text-sm text-gray-600">File Anda saat ini:
                                            <a href="{{ Storage::url($pengumpulan->file_path) }}" target="_blank" class="text-blue-500 hover:underline ml-1">
                                                <i class="fa-solid fa-file-arrow-down mr-1"></i> {{ $pengumpulan->nama_file_asli }}
                                            </a>
                                        </p>
                                        <p class="text-sm text-gray-600">Status: <span class="font-bold text-{{ $pengumpulan->status === 'dikumpulkan' ? 'green' : 'orange' }}-600">{{ ucfirst($pengumpulan->status) }}</span></p>
                                        <p class="text-sm text-gray-500">Dikumpulkan pada: {{ $pengumpulan->dikumpulkan_pada ? $pengumpulan->dikumpulkan_pada->format('d M Y, H:i') : 'Belum Dikumpulkan' }}</p>
                                    </div>
                                @else
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600">Anda belum mengumpulkan tugas ini.</p>
                                    </div>
                                @endif

                                <div class="flex justify-end mt-4">
                                    @if($pengumpulan)
                                    @if (now()->greaterThan($tugas->deadline))
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-md font-medium disabled:opacity-50" disabled>
                                            <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Perbarui Pengumpulan
                                        </button>
                                        @else
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 font-medium">
                                            <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Perbarui Pengumpulan
                                        </button>
                                @endif
                                    @else
                                    @if (now()->greaterThan($tugas->deadline))
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md font-medium disabled:opacity-50" disabled>
                                            <i class="fa-solid fa-upload mr-2"></i> Kumpulkan Tugas
                                        </button>
                                        @else
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                                            <i class="fa-solid fa-upload mr-2"></i> Kumpulkan Tugas
                                        </button>
                                @endif
                                    @endif
                                </div>
                            </form>
                        </div>
                    @endif


                    {{-- Bagian Pengumpulan Tugas dari Mahasiswa (Hanya untuk Admin) --}}
                    @if (Auth::check() && Auth::user()->isAdmin())
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <h3 class="text-xl font-semibold text-gray-700 mb-4">Pengumpulan dari Mahasiswa:</h3>

                            @if($tugas->pengumpulanMahasiswas->isEmpty())
                                <div class="bg-gray-100 p-4 rounded-md text-gray-600">
                                    Belum ada mahasiswa yang mengumpulkan tugas ini.
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                        <thead>
                                            <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                                <th class="py-3 px-4 border-b">Nama Mahasiswa</th>
                                                <th class="py-3 px-4 border-b">Status</th>
                                                <th class="py-3 px-4 border-b">Dikumpulkan Pada</th>
                                                <th class="py-3 px-4 border-b">File</th>
                                                <th class="py-3 px-4 border-b">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tugas->pengumpulanMahasiswas as $pengumpulan)
                                                <tr class="hover:bg-gray-50 border-b border-gray-200 last:border-b-0">
                                                    <td class="py-3 px-4 text-sm text-gray-800">
                                                        {{ $pengumpulan->mahasiswa->name }}
                                                        <span class="text-xs text-gray-500 block">{{ $pengumpulan->mahasiswa->email }}</span>
                                                    </td>
                                                    <td class="py-3 px-4 text-sm text-gray-800">
                                                        <span class="font-semibold text-{{ $pengumpulan->status === 'dikumpulkan' ? 'green' : 'orange' }}-600">
                                                            {{ ucfirst($pengumpulan->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="py-3 px-4 text-sm text-gray-800">
                                                        {{ $pengumpulan->dikumpulkan_pada ? $pengumpulan->dikumpulkan_pada->format('d M Y, H:i') : 'N/A' }}
                                                    </td>
                                                    <td class="py-3 px-4 text-sm text-gray-800">
                                                        @if($pengumpulan->file_path)
                                                            <a href="{{ Storage::url($pengumpulan->file_path) }}" target="_blank" class="text-blue-500 hover:underline flex items-center">
                                                                <i class="fa-solid fa-file-arrow-down mr-1"></i> {{ $pengumpulan->nama_file_asli }}
                                                            </a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="py-3 px-4 text-sm text-gray-800">
                                                        {{-- Tambahkan aksi lain jika diperlukan, misal memberi nilai --}}
                                                        {{-- <a href="#" class="text-indigo-600 hover:underline">Nilai</a> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    @endif


                    {{-- Action buttons (Edit/Delete for Admin) --}}
                    <div class="mt-6 flex justify-end items-center space-x-3">
                        <a href="{{ route('kelas.show.section', ['kelas' => $kelas->kode_kelas, 'section' => 'tugas']) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 font-medium">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Tugas
                        </a>

                        @if (Auth::check() && Auth::user()->isAdmin())
                            <a href="{{ route('kelas.tugas.edit', ['kelas' => $kelas->kode_kelas, 'tugas' => $tugas->id]) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 font-medium">
                                <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Tugas
                            </a>
                            <form action="{{ route('kelas.tugas.destroy', ['kelas' => $kelas->kode_kelas, 'tugas' => $tugas->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-medium">
                                    <i class="fa-solid fa-trash-can mr-2"></i> Hapus Tugas
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>