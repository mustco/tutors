<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifikasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg p-6">
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

                <div class="mb-6 flex w-full justify-between items-center">
                    <h3 class="font-semibold md:mb-4 text-xl md:text-2xl">{{ __('Daftar Notifikasi') }}</h3>
                    {{-- Tombol "Buat Notifikasi" hanya untuk admin --}}
                    @if (Auth::check() && Auth::user()->isAdmin())
                        <a href="{{ route('notifications.create') }}" class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition duration-300 group">
                            Buat Notifikasi Baru
                            <i class="fa-solid fa-plus rounded-full p-1 border-2 ms-1 bg-gray-50 text-blue-600 group-hover:scale-105 transition duration-100"></i>
                        </a>
                    @endif
                </div>

                <div class="flex flex-col gap-6">
                    @if ($notifikasis->isEmpty())
                        <div class="flex flex-col items-center justify-center text-center py-10">
                            <div class="p-3 bg-indigo-200 rounded-full flex items-center justify-center mb-4">
                                <i class="fa-solid fa-bell text-6xl text-indigo-500"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak ada Notifikasi</h3>
                            <p class="text-gray-600">Saat ini belum ada notifikasi.</p>
                        </div>
                    @else
                        @foreach ($notifikasis as $notifikasi)
                            <div class="bg-white p-4 rounded-lg border hover:shadow-md relative group">
                                <h4 class="font-bold text-xl mb-2">{{ $notifikasi->judul }}</h4>
                                <p class="text-gray-700 text-sm mb-1">{{ Str::limit($notifikasi->konten, 150) }}</p>

                                <div class="w-full h-[1px] rounded-full bg-gray-200 my-2"></div>

                                <div class="mt-3 flex justify-between items-center gap-2 text-sm text-gray-500">
                                    <div>
                                        <i class="fa-solid fa-clock mr-1"></i> Dibuat: {{ $notifikasi->created_at->format('d M Y, H:i') }}
                                        @if ($notifikasi->jenis === 'kelas' && $notifikasi->kelas)
                                            <span class="ms-3"><i class="fa-solid fa-chalkboard-user mr-1"></i> Kelas: {{ $notifikasi->kelas->nama_kelas }}</span>
                                        @else
                                            <span class="ms-3"><i class="fa-solid fa-globe mr-1"></i> Global</span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('notifications.show', $notifikasi->id) }}" class="text-blue-500 text-sm md:text-base text-md py-1 px-2 md:p-2 border rounded-md md:rounded-lg bg-white border-blue-500 hover:bg-blue-600 hover:text-white transition duration-150"><i class="fa-solid fa-eye"></i> Lihat</a>
                                        {{-- Tombol Edit dan Hapus (hanya tampil jika user adalah admin) --}}
                                        @if (Auth::check() && Auth::user()->isAdmin())
                                            <a href="{{ route('notifications.edit', $notifikasi->id) }}" class="text-yellow-500 text-sm md:text-base text-md py-1 px-2 md:p-2 border rounded-md md:rounded-lg bg-white border-yellow-500 hover:bg-yellow-600 hover:text-white transition duration-150"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                            <form class="inline-block" action="{{ route('notifications.destroy', $notifikasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 text-sm md:text-base text-md py-1 px-2 md:p-2 border rounded-md md:rounded-lg bg-white border-red-500 hover:bg-red-600 hover:text-white transition duration-150"><i class="fa-solid fa-trash"></i> Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>