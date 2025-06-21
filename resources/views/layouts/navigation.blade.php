<!-- Sidebar -->
<aside id="sidebar" class="sticky h-screen top-0 hidden w-64 bg-slate-900 border-r text-white md:flex flex-col justify-between">
    <div>
        <div class="flex items-center gap-2 px-6 py-6 text-2xl font-bold justify-center">
            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 576 512">
                <path
                    d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5l0-377.4c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C93.5 32 46.3 45.3 18.1 56.1C6.8 60.5 0 71.7 0 83.8L0 454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5l0-370.3c0-12.1-6.8-23.3-18.1-27.6C529.7 45.3 482.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11L304 456c0 11.4 11.7 19.3 22.4 15.5z" />
            </svg>
            <span>Tutors</span>
        </div>
        <nav class="mt-4 flex flex-col">
            <!-- Beranda/Dashboard -->
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-2 px-6 py-3 justify-center
                      {{ request()->routeIs('dashboard') ? 'bg-slate-700 border-r-4 border-blue-400' : 'hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 576 512">
                    <path
                        d="M575.8 255.5c0 18-15 32.1-32 32.1l-32 0 .7 160.2c0 2.7-.2 5.4-.5 8.1l0 16.2c0 22.1-17.9 40-40 40l-16 0c-1.1 0-2.2 0-3.3-.1c-1.4 .1-2.8 .1-4.2 .1L416 512l-24 0c-22.1 0-40-17.9-40-40l0-24 0-64c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32 14.3-32 32l0 64 0 24c0 22.1-17.9 40-40 40l-24 0-31.9 0c-1.5 0-3-.1-4.5-.2c-1.2 .1-2.4 .2-3.6 .2l-16 0c-22.1 0-40-17.9-40-40l0-112c0-.9 0-1.9 .1-2.8l0-69.7-32 0c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L564.8 231.5c8 7 12 15 11 24z" />
                </svg>
                <span class="{{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}">Beranda</span>
            </a>

            <!-- kelas -->
            <a href="{{ route('kelas.index') }}" 
               class="flex items-center gap-2 px-6 py-3 justify-center
                      {{ request()->routeIs('kelas.*') ? 'bg-slate-700 border-r-4 border-blue-400' : 'hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 576 512">
                    <path
                        d="M88.7 223.8L0 375.8 0 96C0 60.7 28.7 32 64 32l117.5 0c17 0 33.3 6.7 45.3 18.7l26.5 26.5c12 12 28.3 18.7 45.3 18.7L416 96c35.3 0 64 28.7 64 64l0 32-336 0c-22.8 0-43.8 12.1-55.3 31.8zm27.6 16.1C122.1 230 132.6 224 144 224l400 0c11.5 0 22 6.1 27.7 16.1s5.7 22.2-.1 32.1l-112 192C453.9 474 443.4 480 432 480L32 480c-11.5 0-22-6.1-27.7-16.1s-5.7-22.2 .1-32.1l112-192z" />
                </svg>
                <span class="{{ request()->routeIs('kelas.*') ? 'font-semibold' : '' }}">Kelas</span>
            </a>

            <!-- Notifikasi -->
            <a href="{{ route('notifications.index') }}" 
               class="flex items-center gap-2 px-6 py-3 justify-center
                      {{ request()->routeIs('notifications.*') ? 'bg-slate-700 border-r-4 border-blue-400' : 'hover:bg-slate-700' }}">
                <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 448 512">
                    <path
                        d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416l384 0c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8l0-18.8c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z" />
                </svg>
                <span class="{{ request()->routeIs('notifications.*') ? 'font-semibold' : '' }}">Notifikasi</span>
            </a>
        </nav>
    </div>
    <div class="px-6 py-4">
        <form
            class="text-red-500 hover:text-red-600 flex items-center gap-2 justify-center border py-2 bg-white rounded-full hover:bg-slate-200"
            method="POST" action="{{ route('logout') }}">
            @csrf
            <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512">
                <path
                    d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z" />
            </svg>
            <button type="submit" class="font-semibold">Log-Out</button>
        </form>
    </div>
</aside>