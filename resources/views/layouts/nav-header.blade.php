 <!-- Top Navbar -->
 <header class="bg-slate-900 text-white border-b shadow:lg px-6 py-4 flex justify-between md:justify-end items-center">
                <button onclick="openSidebar()" class="md:hidden font-bold">
                <i class="fa-solid fa-bars"></i> Menu
                </button>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <div class="font-semibold">{{ Auth::user()->name }}</div>
                        <div class="text-sm">{{ Auth::user()->role }}</div>
                    </div>
                    <div class="w-10 h-10 bg-slate-600 rounded-full flex items-center justify-center text-white">
                       <!-- Profile Button -->
        <a href="{{ route('profile.edit') }}" class="w-10 h-10 bg-slate-600 rounded-full flex items-center justify-center text-white hover:bg-slate-700 transition">
            <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 448 512">
                <path
                    d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
            </svg>
        </a>
</form>
                    </div>
                </div>
            </header>