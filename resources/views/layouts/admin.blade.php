<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SiGOR PKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen flex flex-col md:flex-row">

    <!-- Sidebar Admin -->
    <aside class="w-full md:w-64 bg-slate-900 text-white flex-shrink-0 flex flex-col justify-between border-r border-slate-800">
        <div>
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-slate-800 flex justify-between items-center">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        SiGOR <span class="text-white">PKU</span>
                    </span>
                </a>
                <span class="text-xs bg-red-500/20 text-red-400 border border-red-500/30 font-bold px-2 py-0.5 rounded-full uppercase">Admin</span>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i> Dashboard
                </a>
                <a href="{{ route('admin.pemilik-gor.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('admin.pemilik-gor*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user-check w-5 text-center"></i> Verifikasi Pemilik
                </a>
                <a href="{{ route('admin.jenis-lapangan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('admin.jenis-lapangan*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-layer-group w-5 text-center"></i> Jenis Lapangan
                </a>
                <a href="{{ route('admin.transaksi') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('admin.transaksi*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-money-bill-transfer w-5 text-center"></i> Monitor Transaksi
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold transition-all {{ request()->routeIs('admin.profile*') ? 'bg-blue-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <i class="fa-solid fa-user w-5 text-center"></i> Edit Profil
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center gap-3 px-4 py-3 rounded-lg bg-slate-800/50 mb-3">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-sm font-bold text-white uppercase">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-xs font-semibold truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <p class="text-[10px] text-slate-400 truncate">{{ Auth::user()->email ?? 'admin@sigorpku.com' }}</p>
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
            <div class="text-sm text-slate-500 font-semibold">
                {{ now()->isoFormat('D MMMM YYYY') }}
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
