<!DOCTYPE html>
<html lang="id">
<head>
    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiGOR PKU') - Portal Lapangan Olahraga Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar Global -->
    <header class="bg-white border-b border-slate-100 py-4 px-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center gap-2">
                <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    SiGOR <span class="text-slate-900">PKU</span>
                </span>
            </a>
            <div class="flex items-center gap-4">
                @include('components.theme-toggle')
                <span class="text-sm text-slate-500 font-medium hidden sm:inline">Pekanbaru Sports Portal</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center p-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-6 text-center text-xs text-slate-400 font-medium">
        &copy; 2026 SiGOR PKU. Hak Cipta Dilindungi. Pekanbaru, Riau.
    </footer>

</body>
</html>
