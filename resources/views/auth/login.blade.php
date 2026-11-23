<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="text-xl font-semibold text-gray-800">Pribadi ID</h1>
        <p class="text-sm text-gray-500">Masuk untuk melanjutkan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                          required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat Login</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>Masuk</x-primary-button>
        </div>
    </form>

    <p class="mt-6 text-center text-xs text-gray-500">
        Lupa password atau belum punya akun? Hubungi admin sekolah.
    </p>
</x-guest-layout>