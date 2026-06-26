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
    <title>@yield('title', 'Pemilik GOR Dashboard') - SiGOR PKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen flex flex-col md:flex-row">

    <!-- Sidebar Pemilik -->
    <aside class="w-full md:w-64 md:h-screen md:sticky md:top-0 md:overflow-y-auto bg-slate-900 text-white flex-shrink-0 flex flex-col justify-between border-r border-slate-800">
        <div>
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-slate-800 flex justify-between items-center">
                <a href="{{ route('pemilik.dashboard') }}" class="flex items-center gap-2">
                    <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        SiGOR <span class="text-white">PKU</span>
                    </span>
                </a>
                <span class="text-xs bg-amber-500/20 text-amber-400 border border-amber-500/30 font-bold px-2 py-0.5 rounded-full uppercase">Pemilik</span>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('pemilik.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('pemilik.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i> Dashboard
                </a>
                <a href="{{ route('pemilik.venue.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('pemilik.venue*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-building w-5 text-center"></i> Venue / GOR
                </a>
                <a href="{{ route('pemilik.lapangan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('pemilik.lapangan*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-futbol w-5 text-center"></i> Lapangan
                </a>
                <a href="{{ route('pemilik.jadwal.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('pemilik.jadwal*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-calendar-days w-5 text-center"></i> Jadwal Lapangan
                </a>
                <a href="{{ route('pemilik.pembayaran.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('pemilik.pembayaran*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-receipt w-5 text-center"></i> Pesanan Masuk
                </a>
                <a href="{{ route('pemilik.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('pemilik.profile*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user w-5 text-center"></i> Edit Profil
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center gap-3 px-4 py-3 rounded-lg bg-slate-800/50 mb-3">
                <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center text-sm font-bold text-white uppercase">
                    {{ substr(Auth::guard('pemilik')->user()->nama ?? 'P', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-semibold truncate">{{ Auth::guard('pemilik')->user()->nama ?? 'Pemilik GOR' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::guard('pemilik')->user()->nama_usaha ?? 'Usaha GOR' }}</p>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-semibold text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all">
                <i class="fa-solid fa-right-from-bracket w-5 text-center"></i> Keluar
            </a>
        </div>
    </aside>

    <!-- Main Section -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Bar -->
        <header class="bg-white border-b border-slate-100 py-4 px-6 md:px-8 flex justify-between items-center">
            <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                @yield('header_title', 'Dashboard')
            </h2>
            <div class="flex items-center gap-4">
                @include('components.theme-toggle')
                <div class="text-sm text-slate-500 font-semibold">
                    {{ now()->isoFormat('D MMMM YYYY') }}
                </div>
            </div>
        </header>

        <!-- Main Dashboard Content -->
        <main class="flex-grow p-6 md:p-8 overflow-y-auto">
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
    </div>

</body>
</html>
