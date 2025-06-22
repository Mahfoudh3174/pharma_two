<x-app-layout title="{{ $category->name }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if($category->svg_logo)
                        <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                            <img src="{{ $category->svg_logo_url }}" alt="{{ $category->name }}" class="w-10 h-10 text-blue-600">
                        </div>
                    @else
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                        <p class="text-gray-600">{{ $category->medications->count() }} médicament(s) dans cette catégorie</p>
                    </div>
                </div>
                <a href="{{ route('categories.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour aux catégories
                </a>
            </div>
        </div>

        <!-- Liste des médicaments -->
        @if($category->medications->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($category->medications as $medication)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                @if($medication->image)
                                    <img src="{{ asset('storage/' . $medication->image) }}" 
                                         alt="{{ $medication->name }}" 
                                         class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $medication->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $medication->generic_name }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><strong>Dosage:</strong> {{ $medication->strength }}</p>
                            <p><strong>Forme:</strong> {{ $medication->dosage_form }}</p>
                            <p><strong>Prix:</strong> {{ number_format($medication->price, 2) }} UM</p>
                            <p><strong>Stock:</strong> 
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($medication->quantity == 0) bg-red-100 text-red-800
                                    @elseif($medication->quantity < 10) bg-orange-100 text-orange-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ $medication->quantity }}
                                </span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Aucun médicament dans cette catégorie</h3>
                <p class="mt-1 text-sm text-gray-500">Aucun médicament n'a encore été ajouté à cette catégorie.</p>
            </div>
        @endif
    </div>
</x-app-layout> 