<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiGOR PKU') - Sistem Informasi Gedung Olahraga Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar Pelanggan -->
    <header class="bg-white border-b border-slate-100 sticky top-0 z-50 py-4 px-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            
            <!-- Logo -->
            <a href="{{ route('pelanggan.dashboard') }}" class="flex items-center gap-2">
                <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    SiGOR <span class="text-slate-900">PKU</span>
                </span>
            </a>

            <!-- Navigation -->
            <div class="flex items-center gap-6">
                <a href="{{ route('pelanggan.dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors {{ request()->routeIs('pelanggan.dashboard') ? 'text-blue-600' : '' }}">
                    Cari Lapangan
                </a>
                <a href="{{ route('pelanggan.pemesanan.index') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors {{ request()->routeIs('pelanggan.pemesanan*') ? 'text-blue-600' : '' }}">
                    Pemesanan Saya
                </a>
                <a href="{{ route('pelanggan.profile.edit') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors {{ request()->routeIs('pelanggan.profile*') ? 'text-blue-600' : '' }}">
                    Profil Saya
                </a>

                <!-- User Dropdown / Profile -->
                <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-xs font-bold text-white uppercase">
                        {{ substr(Auth::guard('pelanggan')->user()->nama ?? 'U', 0, 1) }}
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="text-xs font-bold text-slate-800 leading-none">{{ Auth::guard('pelanggan')->user()->nama }}</p>
                        <p class="text-[10px] text-slate-400">{{ Auth::guard('pelanggan')->user()->email }}</p>
                    </div>
                    <a href="{{ route('logout') }}" class="text-slate-400 hover:text-red-500 transition-colors p-1" title="Keluar">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto p-6 md:p-8">
        @if(session('success'))
            <div class="alert alert-success animate-fade-in mb-6">
                <i class="fa-solid fa-circle-check mr-2"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error animate-fade-in mb-6">
                <i class="fa-solid fa-circle-xmark mr-2"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-8 text-center text-xs text-slate-400 font-medium">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p>&copy; 2026 SiGOR PKU. Hak Cipta Dilindungi.</p>
            <p class="flex gap-4">
                <span class="hover:text-slate-600">Badminton</span>
                <span class="hover:text-slate-600">Futsal</span>
                <span class="hover:text-slate-600">Mini Soccer</span>
                <span class="hover:text-slate-600">Voli</span>
                <span class="hover:text-slate-600">Basket</span>
            </p>
        </div>
    </footer>

</body>
</html>
