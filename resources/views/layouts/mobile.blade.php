  <!-- Sidebar Overlay (mobile only) -->
  <div id="mobileSidebar"
                class="fixed inset-0 bg-slate-800 text-white w-64 z-50 transform -translate-x-full transition-transform duration-300 md:hidden">
                <div class="flex items-center justify-between px-4 py-3 ">
                    <span class="text-lg font-bold">Menu</span>
                    <button onclick="closeSidebar()" class="text-white">
                        ✕
                    </button>
                </div>
                <nav class="flex flex-col px-4 py-2">
                    <a href="#" class="py-2 hover:text-orange-400">Beranda</a>
                    <a href="#" class="py-2 hover:text-orange-400">Program</a>
                    <a href="#" class="py-2 hover:text-orange-400">Notifikasi</a>
                    <a href="#" class="mt-4 text-red-400 hover:text-red-600">Log-Out</a>
                </nav>
            </div>