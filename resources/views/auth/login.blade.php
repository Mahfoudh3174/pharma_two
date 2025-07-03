<x-guest-layout>
        <!-- Form Header -->
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-blue-600">Connexion à Saydeliytek</h2>
            <p class="text-gray-600 mt-2">Accédez à votre espace professionnel</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6 p-4 bg-blue-50 text-blue-700 rounded-lg" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email Field -->
            <div>
                <x-input-label for="email" :value="__('Email professionnel')" class="block text-sm font-medium text-gray-700" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <x-text-input id="email" class="block w-full pl-10" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Password Field -->
            <div>
                <x-input-label for="password" :value="__('Mot de passe')" class="block text-sm font-medium text-gray-700" />
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <x-text-input id="password" class="block w-full pl-10" type="password" name="password" required autocomplete="current-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                

                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div>
                <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Se connecter') }}
                </x-primary-button>
            </div>

            <!-- Registration Link -->
            <div class="text-center text-sm text-gray-600">
                {{ __('Pas encore de compte ?') }}
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 ml-1">
                    {{ __('Créer un compte') }}
                </a>
            </div>
        </form>
</x-guest-layout>