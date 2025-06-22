<x-app-layout title="Catégories de Médicaments">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                <i class="fas fa-tags text-blue-500 mr-2"></i>
                Catégories de Médicaments
            </h1>
            <p class="text-gray-600">
                Les catégories sont prédéfinies par le système pour assurer une classification cohérente des médicaments.
            </p>
        </div>

        <!-- Grille des catégories -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($categories as $category)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            @if($category->svg_logo)
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <img src="{{ $category->svg_logo_url }}" alt="{{ $category->name }}" class="w-6 h-6 text-blue-600">
                                </div>
                            @else
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                            @endif
                            <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                        </div>
                    </div>
                    
                    <div class="text-sm text-gray-600 mb-4">
                        <p>{{ $category->medications_count ?? 0 }} médicament(s) dans cette catégorie</p>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="{{ route('categories.show', $category) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                            Voir les médicaments
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Aucune catégorie trouvée</h3>
                    <p class="mt-1 text-sm text-gray-500">Les catégories seront créées automatiquement par le système.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="mt-8">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
