<x-app-layout>
    <div class="relative z-10 grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-4xl mx-auto mt-10 p-6 lg:p-14 bg-white bg-opacity-55 rounded-lg">
        <!-- Saldo -->
        <div class="bg-orange-400 text-white p-6 rounded-lg shadow-lg">
            <h3 class="flex items-center gap-2 text-lg font-semibold">
                <svg class="w-5 h-5"><!-- icon book --></svg>
                Saldo
            </h3>
            <p class="text-xl font-bold mt-2">Rp 100.000,00</p>
        </div>
        <!-- Pemasukan -->
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
            <h3 class="flex items-center gap-2 text-lg font-semibold">
                <svg class="w-5 h-5"><!-- icon book --></svg>
                Pemasukan
            </h3>
            <p class="text-xl font-bold mt-2">Rp 10.000,00</p>
        </div>
        <!-- Pengeluaran -->
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
            <h3 class="flex items-center gap-2 text-lg font-semibold">
                <svg class="w-5 h-5"><!-- icon truck --></svg>
                Pengeluaran
            </h3>
            <p class="text-xl font-bold mt-2">Rp 20.000,00</p>
        </div>
    </div>
</x-app-layout>
