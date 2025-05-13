<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-user-cog mr-2 text-blue-500"></i>
                Paramètres du Profil
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour au tableau de bord
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- User Profile Summary -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8 border border-gray-100">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="mr-4">
                            <div class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800">{{ Auth::user()->name }}</h3>
                            <p class="text-gray-600"><i class="fas fa-envelope mr-1 text-gray-400"></i> {{ Auth::user()->email }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                                Membre depuis {{ Auth::user()->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column - Profile Info -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Profile Information Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-800">
                                <i class="fas fa-user-edit mr-2 text-blue-500"></i>
                                Informations du Profil
                            </h3>
                        </div>
                        <div class="p-6">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Password Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                            <h3 class="text-lg font-medium text-gray-800">
                                <i class="fas fa-lock mr-2 text-blue-500"></i>
                                Modifier le Mot de Passe
                            </h3>
                        </div>
                        <div class="p-6">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <!-- Right Column - Danger Zone -->
                <div class="space-y-6">
                    <!-- Account Status Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-green-100">
                        <div class="px-6 py-4 border-b border-green-200 bg-green-50">
                            <h3 class="text-lg font-medium text-green-800">
                                <i class="fas fa-shield-alt mr-2 text-green-500"></i>
                                État du Compte
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-gray-600">Statut:</span>
                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Actif
                                </span>
                            </div>
                            <div class="text-sm text-gray-500">
                                <p class="mb-2"><i class="fas fa-check-circle mr-2 text-green-500"></i> Email vérifié</p>
                                <p><i class="fas fa-clock mr-2 text-blue-500"></i> Dernière connexion: {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : 'Jamais' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-red-100">
                        <div class="px-6 py-4 border-b border-red-200 bg-red-50">
                            <h3 class="text-lg font-medium text-red-800">
                                <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                                Zone de Danger
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <h4 class="font-medium text-gray-800 mb-2">Supprimer le Compte</h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
                                </p>
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</x-app-layout>