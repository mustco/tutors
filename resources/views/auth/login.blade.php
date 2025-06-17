<x-guest-layout>
    <h2 class="text-3xl font-bold text-gray-900">Welcome back King!</h2>
    <p class="text-sm text-gray-500">Mulai pembelajaran codingmu jadi lebih asik. Get started for free!</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700">Email</label>
            <input name="email" type="text" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Masukkan Email" required autofocus>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700">Password</label>
            <input name="password" type="password" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Masukkan Password" required>
        </div>

        <div class="mt-6">
            <button class="w-full py-2 px-4 bg-[#3F4D67] text-white rounded-md hover:bg-[#334057]">
                LOGIN
            </button>
        </div>
        <div class="mt-4 text-sm text-center">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
        </div>
    </form>
</x-guest-layout>
