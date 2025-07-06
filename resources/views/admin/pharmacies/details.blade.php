@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2">Pharmacie : {{ $pharmacy->name }}</h1>
        <div class="text-gray-600 mb-2">Propriétaire : <span class="font-semibold">{{ $pharmacy->user->name ?? '-' }}</span></div>
        <div class="text-gray-600 mb-2">Adresse : <span class="font-semibold">{{ $pharmacy->address }}</span></div>
        <div class="text-gray-600 mb-2">Localisation : <span class="font-semibold">Lat : {{ $pharmacy->latitude }}, Lng : {{ $pharmacy->longitude }}</span></div>
        <div class="text-gray-600 mb-2">Ville : <span class="font-semibold">{{ $pharmacy->city }}</span> | Wilaya : <span class="font-semibold">{{ $pharmacy->state }}</span></div>
        <div class="mt-4 bg-green-100 text-green-800 px-4 py-2 rounded inline-block font-semibold">Ventes totales : {{ $totalSales }} MRU</div>
        <a href="{{ route('admin.pharmacies.edit', $pharmacy) }}" class="mt-4 ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Modifier</a>
    </div>

    <!-- Order Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-xl shadow flex items-center gap-4">
            <div class="bg-blue-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Total Commandes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalOrdersCount }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow flex items-center gap-4">
            <div class="bg-green-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Commandes Validées</p>
                <p class="text-2xl font-bold text-gray-900">{{ $validatedOrdersCount }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow flex items-center gap-4">
            <div class="bg-red-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Commandes Rejetées</p>
                <p class="text-2xl font-bold text-gray-900">{{ $rejectedOrdersCount }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow flex items-center gap-4">
            <div class="bg-purple-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l7 7 7-7M19 10v10a1 1 0 001 1h3" /></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Commandes Livrées</p>
                <p class="text-2xl font-bold text-gray-900">{{ $deliveredOrdersCount }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow flex items-center gap-4">
            <div class="bg-yellow-100 p-3 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500 font-medium">Commandes En Cours</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingOrdersCount }}</p>
            </div>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2" /></svg>
            Commandes vendues par cette pharmacie
        </h2>

        <form action="{{ route('admin.pharmacies.details', $pharmacy->id) }}" method="GET" class="mb-8 bg-white p-6 rounded-xl shadow">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" id="search" value="{{ $search }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="sort_by" class="block text-sm font-medium text-gray-700">Sort By</label>
                    <select name="sort_by" id="sort_by" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="id" @if($sortBy === 'id') selected @endif>ID</option>
                        <option value="created_at" @if($sortBy === 'created_at') selected @endif>Date</option>
                        <option value="total_amount" @if($sortBy === 'total_amount') selected @endif>Total Amount</option>
                    </select>
                </div>
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700">Sort Order</label>
                    <select name="sort_order" id="sort_order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="asc" @if($sortOrder === 'asc') selected @endif>Ascending</option>
                        <option value="desc" @if($sortOrder === 'desc') selected @endif>Descending</option>
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">All</option>
                        <option value="VALIDEE" @if($filterStatus === 'VALIDEE') selected @endif>VALIDEE</option>
                        <option value="REJETEE" @if($filterStatus === 'REJETEE') selected @endif>REJETEE</option>
                        <option value="LIVRÉ" @if($filterStatus === 'LIVRÉ') selected @endif>LIVRÉ</option>
                        <option value="PENDING" @if($filterStatus === 'PENDING') selected @endif>PENDING</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md shadow-sm">Apply Filters</button>
                <a href="{{ route('admin.pharmacies.details', $pharmacy->id) }}" class="ml-2 text-gray-600 hover:text-gray-900">Clear Filters</a>
            </div>
        </form>
        <div class="overflow-x-auto rounded-xl shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Commande #</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-3 font-mono">{{ $order->reference ?? $order->id }}</td>
                        <td class="px-6 py-3">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                                @if($order->status === 'VALIDEE') bg-green-100 text-green-800
                                @elseif($order->status === 'REJETEE') bg-red-100 text-red-800
                                @elseif($order->status === 'LIVRÉ') bg-blue-100 text-gray-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-3">{{ $order->total_amount }} MRU</td>
                        <td class="px-6 py-3">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-4 text-center text-gray-400">Aucune commande trouvée pour cette pharmacie.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection 