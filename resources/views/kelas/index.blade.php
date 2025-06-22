<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kelas') }}
        </h2>
    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($kelas->isEmpty())
                    {{-- Tampilkan UI "Kelas belum ditemukan" --}}
                    <div class="flex flex-col items-center justify-center text-center py-10">
                        <div class="p-3 bg-purple-200 rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid fa-ban text-6xl text-purple-500"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Kelas belum ditemukan</h3>
                       
                        {{-- Tombol "Buat Kelas Baru" untuk admin jika tidak ada kelas --}}
                        @if (Auth::check() && Auth::user()->isAdmin())
                        <p class="text-gray-600">Kamu belum membuat kelas</p>
                            <a href="{{ route('kelas.create') }}" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                                Buat Kelas Baru
                            </a>
                            @else
                            <p class="text-gray-600 mb-5">Kamu belum bergabung kelas</p>
                        <a href="{{ route('kelas.join') }}" class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-300 group">
                                Gabung Kelas
                                <i class="fa-solid fa-right-to-bracket ms-1"></i>
                                </a>
                        @endif
                    </div>
                @else
                    @php
                        $backgroundColors = [
                            'bg-red-600', 'bg-blue-600', 'bg-green-600', 'bg-purple-600',
                            'bg-indigo-600', 'bg-pink-600', 'bg-teal-600', 'bg-orange-600',
                            'bg-gray-800', 'bg-cyan-600', 'bg-lime-600'
                        ];
                    @endphp

                    {{-- Tampilkan daftar kelas jika ada --}}
                    <div class="mb-6 flex w-full justify-between items-center">
                        <h3 class="font-semibold md:mb-4 text-xl md:text-2xl">Daftar Kelas Anda:</h3>
                        {{-- Tombol "Tambah Kelas" hanya untuk admin --}}
                        @if (Auth::check() && Auth::user()->isAdmin())
                            <a href="{{ route('kelas.create') }}" class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-300 group">
                                Tambah Kelas
                                <i class="fa-solid fa-plus rounded-full p-1 border-2 ms-1 bg-gray-50 text-blue-600 group-hover:scale-105 transition duration-100"></i>
                            </a>
                            @else
                            <a href="{{ route('kelas.join') }}" class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-300 group">
                                Gabung Kelas
                                <i class="fa-solid fa-right-to-bracket ms-1"></i>
                                </a>
                        @endif
                        
                    </div>
                    <div class="flex flex-col gap-6">
                        @foreach ($kelas as $item)
                            @php
                                $randomColor = $backgroundColors[array_rand($backgroundColors)];
                            @endphp
                            <div class="bg-white p-4 rounded-lg border hover:shadow-md relative group">
                                {{-- Tombol Hapus (hanya tampil jika user adalah admin) --}}
                                @if (Auth::check() && Auth::user()->isAdmin())
                                <form class="group-hover:block hidden absolute top-1 right-2" action="{{ route('kelas.destroy', $item->kode_kelas) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"><i class="fa-solid fa-trash text-red-500 hover:text-red-600 text-lg hover:scale-125"></i></button>
                                </form>
                                @endif
                                
                                <h4 class="font-bold text-xl mb-2">{{ $item->nama_kelas }}</h4>
                                <div class="w-full h-[2px] rounded-full bg-gray-200 mb-2"></div>
                                <p class="text-gray-700 text-sm mb-1">Kode Kelas: <span class="font-semibold">{{ $item->kode_kelas }}</span></p>
                                <p class="text-gray-600 text-sm">{{ Str::limit($item->deskripsi, 50) }}</p>
                                
                                <div class="mt-3 flex justify-between items-center gap-2">
                                    <div>
                                        <p class="text-gray-700 text-sm">
                                            <i class="fa-solid fa-user-graduate mr-1"></i>Siswa: <span class="font-semibold">{{ $item->mahasiswas_count }}</span>
                                        </p>
                                    </div>
                                    <div>
                                        {{-- Tombol Edit (hanya tampil jika user adalah admin) --}}
                                        @if (Auth::check() && Auth::user()->isAdmin())
                                            <a href="{{ route('kelas.edit', $item->kode_kelas) }}" class="text-yellow-500 text-sm md:text-base text-md py-1 px-2 md:p-2 border rounded-md md:rounded-lg bg-white border-yellow-500 hover:bg-yellow-600 hover:text-white transition duration-150"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                        @endif
                                        <a href="{{ route('kelas.show.section', $item->kode_kelas) }}" class="text-blue-500 text-sm md:text-base text-md py-1 px-2 md:p-2 border rounded-md md:rounded-lg bg-white border-blue-500 hover:bg-blue-600 hover:text-white transition duration-150"><i class="fa-solid fa-eye"></i> Lihat</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>