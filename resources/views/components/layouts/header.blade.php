<!-- Header Component -->
<header class="w-full bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo/Branding -->
            <div class="flex-shrink-0 flex items-center">
                <span class="text-xl font-bold text-blue-600">Saydelyti</span></span>
            </div>
            
            <!-- Navigation -->
            @if (Route::has('login'))
                <nav class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-md text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 transition duration-150 ease-in-out">
                            Tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm font-medium text-blue-600 hover:bg-blue-50 transition duration-150 ease-in-out">
                            Connexion
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 transition duration-150 ease-in-out">
                                S'inscrire
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </div>
</header>
