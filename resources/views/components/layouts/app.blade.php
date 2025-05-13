<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Pharmacie+ - Solution professionnelle de gestion pharmaceutique">
    
    <title>{{ $title ?? 'Pharmacie+ - Gestion Pharmaceutique' }}</title>
 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="preload" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Flash Messages Container -->
    <div id="flash-messages" class="fixed top-4 right-4 z-50 space-y-2 w-80">
        @if(session('success'))
            <div class="flash-message bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="flash-message bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <x-layouts.header />

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <x-layouts.footer />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const flashMessages = document.querySelectorAll('.flash-message');
            flashMessages.forEach(message => {
                setTimeout(() => {
                    message.style.transition = 'opacity 1s ease-out';
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 1000);
                }, 5000);
            });
        });
    </script>
</body>
</html>