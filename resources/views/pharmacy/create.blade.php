<x-layouts.app title="Créer Votre Pharmacie">
    <!-- Section de Contenu -->
    <div class="relative z-10 -mt-12 pb-12">
        <div class="max-w-xl mx-auto px-4">
            <!-- En-tête du Formulaire -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Créer Votre Pharmacie</h1>
                <p class="mt-1 text-sm text-gray-600">Enregistrez votre pharmacie pour commencer à gérer les médicaments</p>
            </div>

            <!-- Formulaire -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <form action="{{ route('pharmacy.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Nom de la Pharmacie -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom de la pharmacie *</label>
                        <input type="text" id="name" name="name" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 placeholder-gray-400"
                               placeholder="Pharmacie MedLife">
                    </div>

                    <!-- Adresse Complète -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse complète *</label>
                        <input type="text" id="address" name="address" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 placeholder-gray-400"
                               placeholder="123 Rue Principale">
                    </div>

                    <!-- Champs de Localisation -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ville *</label>
                            <input type="text" id="city" name="city" required 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 placeholder-gray-400"
                                   placeholder="Nouakchott">
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">Région / État *</label>
                            <input type="text" id="state" name="state" required 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 placeholder-gray-400"
                                   placeholder="Région de Nouakchott">
                        </div>
                    </div>

                    <!-- Latitude et Longitude Cachées -->
                    <div>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div>

                    <!-- Texte d'Aide -->
                    <p class="text-xs text-gray-500">
                        Vous pouvez trouver les coordonnées sur 
                        <a href="https://www.google.com/maps" target="_blank" class="text-green-600 hover:underline">Google Maps</a>.
                    </p>

                    <!-- Boutons d'Actions -->
                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 border py-2 px-4 rounded hover:text-gray-900">
                            Annuler
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Créer la Pharmacie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;
                },
                function (error) {
                    console.warn("Accès à la localisation refusé ou échoué :", error.message);
                }
            );
        } else {
            console.warn("La géolocalisation n'est pas prise en charge par ce navigateur.");
        }
    });
    </script>
</x-layouts.app>
