<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelas') }}
        </h2>
    </x-slot>

    <a href="javascript:history.back()" 
   class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 hover:bg-gray-100 hover:shadow-md transition-all duration-200 ease-in-out cursor-pointer group">
    <i class="fa-solid fa-arrow-left text-gray-500 transition-transform duration-300 group-hover:-translate-x-1 group-hover:rotate-[-10deg]"></i>
    <span class="font-medium group-hover:text-gray-900">Kembali</span>
</a>

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

                    {{-- Navigation Buttons --}}
                    <div class="flex border-b pb-2 border-gray-200 space-x-5 mb-6">
                        <a href="{{ route('kelas.show.section', ['kelas' => $kelas->kode_kelas, 'section' => 'materi']) }}"
                           class="rounded-md py-2 px-10 text-center font-medium focus:outline-none transition-colors duration-200 cursor-pointer
                           {{ request()->route('section') === 'materi' || !request()->route('section') ? 'border-2 bg-[#3F4D67] border-gray-600 text-white' : 'border border-gray-600 text-gray-800 hover:text-gray-900 hover:bg-gray-100' }}">
                            Materi
                        </a>
                        <a href="{{ route('kelas.show.section', ['kelas' => $kelas->kode_kelas, 'section' => 'tugas']) }}"
                           class="rounded-md py-2 px-10 text-center font-medium focus:outline-none transition-colors duration-200 cursor-pointer
                           {{ request()->route('section') === 'tugas' ? 'border-2 bg-[#3F4D67] border-gray-600 text-white' : 'border border-gray-600 text-gray-800 hover:text-gray-900 hover:bg-gray-100' }}">
                            Tugas
                        </a>
                        <a href="{{ route('kelas.show.section', ['kelas' => $kelas->kode_kelas, 'section' => 'siswa']) }}"
                           class="rounded-md py-2 px-10 text-center font-medium focus:outline-none transition-colors duration-200 cursor-pointer
                           {{ request()->route('section') === 'siswa' ? 'border-2 bg-[#3F4D67] border-gray-600 text-white' : 'border border-gray-600 text-gray-800 hover:text-gray-900 hover:bg-gray-100' }}">
                            Siswa
                        </a>
                    </div>

                    {{-- Dynamic Content Area --}}
                    <div>
                        @if (request()->route('section') === 'tugas')
                            {{-- Tugas Content --}}
                            @include('kelas.partials.tugas', ['kelas' => $kelas])
                        @elseif (request()->route('section') === 'siswa')
                            {{-- Siswa Content --}}
                            @include('kelas.partials.siswa', ['kelas' => $kelas])
                        @else
                            {{-- materi Content (Default) --}}
                            @include('kelas.partials.materi', ['kelas' => $kelas])
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>