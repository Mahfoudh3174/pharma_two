<x-layouts.app title="Create Your Pharmacy">
    <!-- Content Section -->
    <div class="relative z-10 -mt-12 pb-12">
        <div class="max-w-xl mx-auto px-4">
            <!-- Form Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Create Your Pharmacy</h1>
                <p class="mt-1 text-sm text-gray-600">Register your pharmacy to start managing medications</p>
            </div>

            <!-- Form -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <form action="{{ route('pharmacy.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Pharmacy Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Pharmacy Name *</label>
                        <input type="text" id="name" name="name" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 placeholder-gray-400"
                               placeholder="MedLife Pharmacy">
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Full Address *</label>
                        <input type="text" id="address" name="address" required 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 placeholder-gray-400"
                               placeholder="123 Main Street">
                    </div>

                    <!-- Location Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                            <input type="text" id="city" name="city" required 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 placeholder-gray-400"
                                   placeholder="Mauritania">
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                            <input type="text" id="state" name="state" required 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 placeholder-gray-400"
                                   placeholder="Nouackchott">
                        </div>
                     
                    </div>

                    <!-- Helper Text -->
                    <p class="text-xs text-gray-500">
                        You can find coordinates on 
                        <a href="https://www.google.com/maps" target="_blank" class="text-green-600 hover:underline">Google Maps</a>.
                    </p>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-4">
                        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 border py-2 px-4 rounded hover:text-gray-900">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-sm flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Create Pharmacy
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
