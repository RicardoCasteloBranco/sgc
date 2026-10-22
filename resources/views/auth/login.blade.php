<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
        <div>
            <p class="text-center text-sm">Polícia Militar de Pernambuco</p>
            <h3 class="text-center font-bold uppercase">Sistema de Gestão do Ensino</h3>
        </div>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="username" value="{{ __('Usuário') }}" class="text-white" />
                <x-input id="username" class="block mt-1 w-full bg-transparent text-white placeholder:text-gray-400 border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Senha') }}" class="text-white"/>
                <x-input id="password" class="block mt-1 w-full bg-transparent text-white placeholder:text-gray-400 border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4 bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
