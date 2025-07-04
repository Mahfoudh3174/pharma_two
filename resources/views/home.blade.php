<x-layouts.app>
    <main class="min-h-[calc(100vh-160px)] bg-gray-50">

        <!-- Hero Section with Wave Decoration -->
        <section class="relative bg-gradient-to-br from-blue-700 to-teal-700 text-white overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-y-0 left-0 w-1/3 bg-blue-800 transform -skew-x-12"></div>
                <div class="absolute bottom-0 right-0 w-1/4 h-1/2 bg-teal-500 rounded-full filter blur-3xl opacity-20"></div>
            </div>
            
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center px-4 sm:px-6 lg:px-8 py-24 lg:py-32 relative z-10">
                <div class="text-center lg:text-left max-w-2xl mx-auto lg:mx-0 lg:pr-10">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                        <span class="block">Transformez votre</span>
                        <span class="block text-blue-200">gestion pharmaceutique</span>
                    </h1>
                    <p class="mt-6 text-xl text-blue-100 leading-relaxed">
                        Saydeliytek automatise vos processus et simplifie la gestion quotidienne de votre officine.
                    </p>
                    <div class="mt-10 flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        
                        @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center px-4 py-2 rounded bg-red-600 text-white font-bold ml-0 sm:ml-4 mt-4 sm:mt-0">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Déconnexion
                            </button>
                        </form>
                        @endauth
                    </div>
                    
                    <div class="mt-12 flex flex-wrap justify-center lg:justify-start gap-4 items-center">
                        <div class="flex items-center text-sm text-blue-100">
                            <svg class="h-5 w-5 text-blue-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Performance
                        </div>
                        <div class="flex items-center text-sm text-blue-100">
                            <svg class="h-5 w-5 text-blue-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Rapide
                        </div>
                        <div class="flex items-center text-sm text-blue-100">
                            <svg class="h-5 w-5 text-blue-300 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            sécurisé
                        </div>
                    </div>
                </div>
                <div class="mt-16 lg:mt-0 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2 flex justify-center items-center">
                    <img src="{{ asset('images/pharmacy-illustration.avif') }}" alt="Illustration de gestion pharmaceutique" 
                        class="object-contain w-full max-w-md lg:max-w-2xl lg:h-[90%] transform transition hover:scale-105 duration-300">
                </div>
            </div>
            
            <!-- Wave divider -->
            <div class="absolute bottom-0 left-0 right-0 overflow-hidden">
                <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-current text-white w-full h-16">
                    <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25"></path>
                    <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5"></path>
                    <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"></path>
                </svg>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-blue-600 text-base font-semibold uppercase tracking-wider">Fonctionnalités</h2>
                    <p class="mt-2 text-3xl sm:text-4xl font-extrabold text-gray-900">
                        Optimisez votre pharmacie
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                        Une suite complète d'outils conçus pour les professionnels de santé
                    </p>
                </div>

                <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ([
                        [
                            'title' => 'Gestion des stocks intelligente', 
                            'desc' => 'Suivi en temps réel avec alertes de péremption et suggestions de réapprovisionnement automatiques.', 
                            'icon' => 'fa-solid fa-prescription-bottle',
                            'features' => ['Alertes de stocks bas', 'Gestion des lots', 'Suivi des péremptions']
                        ],
                        [
                            'title' => 'Suivi des commandes', 
                            'desc' => 'Visualisation complète du cycle de commande avec intégration des ordonnances électroniques.', 
                            'icon' => 'fa-solid fa-truck-fast',
                            'features' => ['Historique complet', 'Statut en temps réel', 'Notifications']
                        ],
                        [
                            'title' => 'Sécurité & conformité', 
                            'desc' => 'Protocoles avancés et outils de conformité réglementaire intégrés.', 
                            'icon' => 'fa-solid fa-shield-halved',
                            'features' => ['Chiffrement AES-256', 'Audit trail', 'Certifications']
                        ]
                    ] as $feature)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="p-6">
                                <div class="flex justify-center items-center h-12 w-12 rounded-lg bg-blue-100 text-blue-600">
                                    <i class="{{$feature['icon']}}"></i>
                                </div>
                                <h3 class="mt-6 text-xl font-semibold text-gray-900">{{ $feature['title'] }}</h3>
                                <p class="mt-4 text-gray-500">{{ $feature['desc'] }}</p>
                                
                                <ul class="mt-6 space-y-2">
                                    @foreach ($feature['features'] as $item)
                                        <li class="flex items-start">
                                            <svg class="h-5 w-5 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-gray-600">{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                    
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="bg-gray-50 py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-gradient-to-r from-blue-600 to-teal-600 rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-6 py-12 sm:p-16">
                        <div class="max-w-3xl mx-auto text-center">
                            <h2 class="text-3xl font-extrabold text-white">Saydeliytek en chiffres</h2>
                            <p class="mt-4 text-lg text-blue-100">
                                La solution préférée des professionnels de santé
                            </p>
                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-3">
                            @foreach ([
                                ['value' => '1,200+', 'label' => 'Pharmacies partenaires'],
                                ['value' => '99.9%', 'label' => 'Disponibilité'],
                                ['value' => '24/7', 'label' => 'Support technique']
                            ] as $stat)
                                <div class="text-center bg-white bg-opacity-10 backdrop-filter backdrop-blur-sm rounded-lg p-6">
                                    <p class="text-4xl font-extrabold text-white">{{ $stat['value'] }}</p>
                                    <p class="mt-2 text-sm font-medium text-blue-100">{{ $stat['label'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
</x-layouts.app>