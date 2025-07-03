@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow flex items-center gap-4">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4V7a4 4 0 10-8 0v3m12 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2v-1" /></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Utilisateurs totaux</p>
                <p class="text-2xl font-bold text-gray-900">{{ $userCount }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow flex items-center gap-4">
            <div class="bg-green-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2" /></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Pharmacies totales</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pharmacyCount }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow flex items-center gap-4">
            <div class="bg-indigo-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Ventes totales</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalSales }} MRU</p>
            </div>
        </div>
    </div>

    <!-- Users with Pharmacies -->
    <div class="mb-12">
        <div class="flex items-center gap-2 mb-4">
            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4V7a4 4 0 10-8 0v3m12 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2v-1" /></svg>
            <h2 class="text-xl font-bold text-gray-800">Utilisateurs avec pharmacies</h2>
        </div>
        <div class="overflow-x-auto rounded-xl shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pharmacie</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($usersWithPharmacies as $user)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-3">{{ $user->id }}</td>
                        <td class="px-6 py-3 font-semibold text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-3">{{ $user->email }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $user->pharmacy->name ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-3">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-4 text-center text-gray-400">Aucun utilisateur avec pharmacie trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Regular Users -->
    <div class="mb-12">
        <div class="flex items-center gap-2 mb-4">
            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            <h2 class="text-xl font-bold text-gray-800">Utilisateurs réguliers</h2>
        </div>
        <div class="overflow-x-auto rounded-xl shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($regularUsers as $user)
                    <tr class="hover:bg-green-50 transition">
                        <td class="px-6 py-3">{{ $user->id }}</td>
                        <td class="px-6 py-3 font-semibold text-gray-800">{{ $user->name }}</td>
                        <td class="px-6 py-3">{{ $user->email }}</td>
                        <td class="px-6 py-3">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-4 text-center text-gray-400">Aucun utilisateur régulier trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pharmacies -->
    <div>
        <h2 class="text-2xl font-bold mb-4">Pharmacies</h2>
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4">ID</th>
                    <th class="py-2 px-4">Nom</th>
                    <th class="py-2 px-4">Propriétaire</th>
                    <th class="py-2 px-4">Localisation</th>
                    <th class="py-2 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pharmacies as $pharmacy)
                <tr>
                    <td class="py-2 px-4">{{ $pharmacy->id }}</td>
                    <td class="py-2 px-4">{{ $pharmacy->name }}</td>
                    <td class="py-2 px-4">{{ $pharmacy->user->name ?? '-' }}</td>
                    <td class="py-2 px-4">{{ $pharmacy->address }}<br>Lat: {{ $pharmacy->latitude }}, Lng: {{ $pharmacy->longitude }}</td>
                    <td class="py-2 px-4 flex gap-2">
                        <form action="{{ route('admin.pharmacies.destroy', $pharmacy->id) }}" method="POST" onsubmit="return confirm('Supprimer cette pharmacie ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Supprimer</button>
                        </form>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $pharmacy->latitude }},{{ $pharmacy->longitude }}" target="_blank" class="bg-green-500 text-white px-3 py-1 rounded">Voir sur la carte</a>
                        <a href="{{ route('admin.pharmacies.details', $pharmacy->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded">Détails</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 