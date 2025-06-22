<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gabung Kelas') }}
        </h2>
    </x-slot>

    <a href="javascript:history.back()" 
   class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 hover:bg-gray-100 hover:shadow-md transition-all duration-200 ease-in-out cursor-pointer group">
    <i class="fa-solid fa-arrow-left text-gray-500 transition-transform duration-300 group-hover:-translate-x-1 group-hover:rotate-[-10deg]"></i>
    <span class="font-medium group-hover:text-gray-900">Kembali</span>
</a>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">Gabung ke Kelas</h3>

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

                <form action="{{ route('kelas.process_join') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="kode_kelas" class="block text-sm font-medium text-gray-700">Kode Kelas</label>
                        <input type="text" name="kode_kelas" id="kode_kelas"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                               placeholder="Masukkan kode kelas" required>
                        @error('kode_kelas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">Gabung</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>