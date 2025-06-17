<x-guest-layout>
    <h2 class="text-3xl font-bold text-gray-900">Buat Akun dulu King!</h2>
    <p class="text-sm text-gray-500">Gabung sekarang dan mulai belajar coding dengan lebih seru. Get started for free!</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
            <input name="name" type="text" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Masukkan Nama Lengkap" required autofocus>
        </div>

        <!-- Email -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700">Email</label>
            <input name="email" type="email" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Masukkan Email" required>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700">Password</label>
            <input name="password" type="password" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Masukkan Password" required>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700">Konfirmasi Password</label>
            <input name="password_confirmation" type="password" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Ulangi Password" required>
        </div>

        <div class="mt-6">
            <button class="w-full py-2 px-4 bg-[#3F4D67] text-white rounded-md hover:bg-[#334057]">
                DAFTAR
            </button>
        </div>

        <div class="mt-4 text-sm text-center">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Masuk di sini</a>
        </div>
    </form>
</x-guest-layout>
