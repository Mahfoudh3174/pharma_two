<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-gray-900 text-white py-4 mb-8">
        <div class="container mx-auto flex justify-between items-center px-4">
            <h1 class="text-xl font-bold">Panneau d'administration</h1>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="mr-4 hover:underline">Tableau de bord</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline bg-transparent border-0 p-0 m-0 text-white cursor-pointer">Déconnexion</button>
                </form>
            </nav>
        </div>
    </header>
    <main class="container mx-auto px-4">
        @yield('content')
    </main>
</body>
</html> 