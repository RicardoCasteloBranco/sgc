<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="text-center text-2xl font-bold mt-4">
                Adicionar Novos Usuários
            </div>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" class="text-white"/>
                <x-input id="name" class="block mt-1 w-full text-black" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"/>
            </div>
            <div>
                <x-label for="login" value="{{ __('CPF') }}" class="text-white"/>
                <x-input id="login" class="block mt-1 w-full text-black" type="number" name="login" :value="old('login')" required autofocus autocomplete="login"/>
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" class="text-white" />
                <x-input id="email" class="block mt-1 w-full text-black" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="matricula" value="{{ __('Matrícula') }}" class="text-white" />
                <x-input id="matricula" class="block mt-1 w-full text-black" type="text" name="matricula" :value="old('matricula')" required autofocus autocomplete="matricula"/>
            </div>

            <div class="mt-4">
                <x-label for="cargo" value="{{ __('Cargo') }}" class="text-white" />
                <x-input id="cargo" class="block mt-1 w-full text-black" type="text" name="cargo" :value="old('cargo')" required autofocus autocomplete="cargo"/>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
                <x-button class="ms-4" onclick="window.location='{{ route('dashboard') }}'">
                    {{ __('Voltar') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
