<x-app-layout title="Tableau de Bord du Pharmacien">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                
                
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                    @isset($pharmacy)
                        <span class="text-green-600">{{ $pharmacy->name }}</span> - Gestion des Médicaments
                    @else
                        <i class="fas fa-clinic-medical text-blue-500 mr-2"></i>Tableau de Bord 
                    @endisset
                </h1>
                <p class="text-gray-600 mt-2">
                    @isset($pharmacy)
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $pharmacy->address }}
                        </span>
                    @else
                        <i class="fas fa-cog text-gray-400 mr-1"></i>Configurez votre pharmacie pour commencer
                    @endisset
                </p>
            </div>
            
            @isset($pharmacy)
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <a href="{{ route('medications.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition-colors flex items-center justify-center gap-2 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Ajouter un Médicament
                    </a>
                </div>
            @else
                 <a href="{{ route('pharmacy.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg transition-all flex items-center justify-center gap-2 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    <i class="fas fa-plus-circle mr-1"></i>
                    Créer une Pharmacie
                </a>
            @endisset
        </div>


        @isset($pharmacy)
            <!-- Cartes de Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Médicaments Totaux</p>
                            <h3 class="text-2xl font-bold mt-1">{{ $pharmacy->medications()->count() }}</h3>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">+{{ rand(1, 10) }}% ce mois</p>
                </div>
                
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Stock Faible (<10)</p>
                            <h3 class="text-2xl font-bold mt-1 text-orange-600">{{ $pharmacy->low_stock_count }}</h3>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">À réapprovisionner</p>
                </div>
                
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">En Rupture</p>
                            <h3 class="text-2xl font-bold mt-1 text-red-600">{{ $pharmacy->out_of_stock_count }}</h3>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Urgent à commander</p>
                </div>
                
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Valeur du Stock</p>
                            <h3 class="text-2xl font-bold mt-1 text-indigo-600">
                                {{ number_format($pharmacy->totalValue, 2, ',', ' ') }} UM
                            </h3>
                        </div>
                        <div class="bg-indigo-100 p-3 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Valeur totale estimée</p>
                </div>
            </div>

            <!-- Recherche et Filtres -->
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-8">
                <form action="{{ route('dashboard', $pharmacy) }}" method="GET" class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-12 sm:gap-4">
                    <div class="sm:col-span-5 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Rechercher des médicaments..." 
                            value="{{ request('search') }}"
                            class="w-full pl-10 border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        >
                    </div>
                    
                    <div class="sm:col-span-3">
                        <select name="category" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Toutes Catégories</option>
                            
                        </select>
                    </div>
                    
                    <div class="sm:col-span-2">
                        <select name="stock_status" class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Tous les stocks</option>
                           
                        </select>
                    </div>
                    
                    <div class="sm:col-span-2 flex gap-2">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filtrer
                        </button>
                        <a href="{{ route('dashboard', $pharmacy) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </a>
                    </div>
                </form>
            </div>

                <!-- Tableau des Médicaments -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-2">
                <div class="overflow-x-auto">
                    <table id="medicationsTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(0)">
                                    <div class="flex items-center">
                                        Nom
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Catégorie
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(2, true)">
                                    <div class="flex items-center">
                                        Stock
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" onclick="sortTable(3, true)">
                                    <div class="flex items-center">
                                        Prix
                                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($medications as $med)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-green-100 rounded-full flex items-center justify-center">
                                            @if($med->quantity == 0)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                </svg>
                                            @elseif($med->quantity < 10)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $med->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $med->generic_name ?? 'Générique' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($med->category)
                                            bg-blue-100 text-blue-800
                                        @else
                                            bg-gray-100 text-gray-800
                                        @endif
                                        flex items-center gap-1 w-max">
                                        {{ $med->category ? $med->category->name : 'Non spécifié' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($med->quantity == 0)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 flex items-center gap-1 w-max">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Rupture
                                        </span>
                                    @elseif($med->quantity < 10)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800 flex items-center gap-1 w-max">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                                            </svg>
                                            {{ $med->quantity }} (Faible)
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex items-center gap-1 w-max">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ $med->quantity }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ number_format($med->pivot->price, 2) }} UM
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('medications.edit', $med) }}" class="text-green-600 hover:text-green-900 flex items-center gap-1" title="Modifier">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('medications.destroy', $med) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 flex items-center gap-1" title="Retirer" onclick="return confirm('Retirer ce médicament de votre pharmacie ?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-lg font-medium text-gray-900">Aucun médicament trouvé</h3>
                                    <p class="mt-1 text-sm text-gray-500">Essayez d'ajuster vos filtres de recherche ou <a href="{{ route('medications.create') }}" class="text-green-600 hover:underline">ajoutez un nouveau médicament</a>.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($medications->hasPages())
                <div class="px-6 py-4 border-t bg-gray-50 flex flex-col sm:flex-row items-center justify-between">
                    <div class="text-sm text-gray-700 mb-2 sm:mb-0">
                        Affichage de <span class="font-medium">{{ $medications->firstItem() }}</span> à <span class="font-medium">{{ $medications->lastItem() }}</span> sur <span class="font-medium">{{ $medications->total() }}</span> résultats
                    </div>
                    <div class="flex items-center space-x-1">
                        {{ $medications->withQueryString()->links() }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Section des Commandes -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-4">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-900">Gestion des Commandes</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    N° Commande
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Client
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Montant
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($commandes as $commande )
                                
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{$commande->uuid}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{$commande->user->name}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{$commande->date}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{$commande->amount}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    {{$commande->status}}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{route("commandes.validate", $commande->id)}}" class="text-green-600 hover:text-green-900">
                                            Valider
                                        </a>
                                        <button onclick="showRejectModal({{$commande->id}})" class="text-red-600 hover:text-red-900">
                                            Rejeter
                                        </button>
                                        <a href="{{route('commandes.details', $commande->id)}}" class="text-blue-600 hover:text-blue-900">
                                            Détails
                                        </a>
                                    </div>
                                </td>
                            </tr>
                
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        @else
         <!-- No Pharmacy State - Professional Version -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 max-w-5xl mx-auto">
            <!-- Setup Process Section -->
            <div class="px-10 py-12">
                <div class="mb-12">
                    <h3 class="text-xl font-semibold text-gray-800 mb-8 text-center">
                        <span class="inline-flex items-center justify-center bg-blue-100 text-blue-600 rounded-full w-10 h-10 mr-3">
                            <i class="fas fa-cog"></i>
                        </span>
                        Procédure d'Initialisation
                    </h3>
                    
                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Step 1 -->
                        <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col items-center">
                                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-50 text-blue-600 mb-4 text-xl font-bold border-2 border-blue-100">
                                    1
                                </div>
                                <h4 class="font-semibold text-gray-800 text-center mb-2">Enregistrement de l'Établissement</h4>
                                <p class="text-sm text-gray-600 text-center">Saisissez les informations légales et administratives de votre pharmacie</p>
                            </div>
                        </div>
                        
                        <!-- Step 2 -->
                        <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col items-center">
                                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-50 text-blue-600 mb-4 text-xl font-bold border-2 border-blue-100">
                                    2
                                </div>
                                <h4 class="font-semibold text-gray-800 text-center mb-2">Paramétrage du Système</h4>
                                <p class="text-sm text-gray-600 text-center">Configurez les préférences et options de gestion selon vos besoins</p>
                            </div>
                        </div>
                        
                        <!-- Step 3 -->
                        <div class="bg-white p-6 rounded-lg border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col items-center">
                                <div class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-50 text-blue-600 mb-4 text-xl font-bold border-2 border-blue-100">
                                    3
                                </div>
                                <h4 class="font-semibold text-gray-800 text-center mb-2">Initialisation du Stock</h4>
                                <p class="text-sm text-gray-600 text-center">Ajoutez vos références produits et niveaux de stock initiaux</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Section -->
                <div class="text-center">
                    <div class="mb-8">
                        <div class="inline-flex items-center bg-blue-50 px-4 py-2 rounded-full mb-3">
                            <i class="fas fa-clock text-blue-500 mr-2"></i>
                            <span class="text-sm font-medium text-blue-600">Configuration estimée : 5-10 minutes</span>
                        </div>
                        <p class="text-gray-600 max-w-2xl mx-auto">Pour accéder à l'ensemble des fonctionnalités professionnelles de gestion de pharmacie, veuillez compléter la configuration initiale.</p>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('pharmacy.create') }}" class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm hover:shadow-md transition-all duration-200">
                            <i class="fas fa-plus-circle mr-2 text-lg"></i>
                            Initialiser la Configuration
                        </a>
                    </div>
             
                </div>
            </div>
        </div>
        @endisset
    </div>

    <!-- Reject Order Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <form action="{{route("commandes.reject")}}" method="POST">
                    @csrf
                <input type="hidden" name="order_id" id="order_id" required>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Rejeter la Commande</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500 mb-4">Veuillez indiquer la raison du rejet :</p>
                    <textarea id="rejectReason" required name="reject_reason" rows="3" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" placeholder="Raison du rejet..."></textarea>
                </div>
                <div class="items-center px-4 py-3">
                    <button type="submit" id="confirmReject" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Confirmer
                    </button>
                    <button onclick="document.getElementById('rejectModal').classList.add('hidden')" class="ml-3 px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Annuler
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Table sorting function
        function sortTable(columnIndex, isNumeric = false) {
            const table = document.getElementById("medicationsTable");
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));
            
            // Determine sort direction
            const header = table.querySelectorAll("th")[columnIndex];
            const isAscending = !header.classList.contains("asc");
            
            // Clear other sort indicators
            table.querySelectorAll("th").forEach(th => {
                th.classList.remove("asc", "desc");
            });
            
            // Set sort indicator on current column
            header.classList.add(isAscending ? "asc" : "desc");
            
            // Sort rows
            rows.sort((a, b) => {
                const aCell = a.cells[columnIndex];
                const bCell = b.cells[columnIndex];
                
                let aValue = aCell.textContent.trim();
                let bValue = bCell.textContent.trim();
                
                if (isNumeric) {
                    // Extract numbers from strings if needed
                    aValue = parseFloat(aValue.replace(/[^\d.-]/g, '')) || 0;
                    bValue = parseFloat(bValue.replace(/[^\d.-]/g, '')) || 0;
                    return isAscending ? aValue - bValue : bValue - aValue;
                } else {
                    return isAscending 
                        ? aValue.localeCompare(bValue)
                        : bValue.localeCompare(aValue);
                }
            });
            
            // Reattach sorted rows
            rows.forEach(row => tbody.appendChild(row));
        }
    
        function showRejectModal(orderId) {
            document.getElementById("order_id").value= orderId;
            document.getElementById('rejectModal').classList.remove('hidden');
        }
        
    </script>
</x-app-layout>