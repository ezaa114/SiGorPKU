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
    <title>SiGOR PKU - Portal Marketplace Booking Lapangan Olahraga Pekanbaru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(2deg); }
        }
        @keyframes pulse-glow {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        .glow-circle {
            animation: pulse-glow 8s ease-in-out infinite;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        [data-theme="dark"] .glass-header {
            background: rgba(26, 26, 26, 0.8) !important;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .glass-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between overflow-x-hidden">

    <!-- Global Header / Navbar -->
    <header class="sticky top-0 z-50 glass-header border-b border-slate-100 py-4 px-6 md:px-12 transition-all">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-2 group">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-105 transition-transform">
                    <i class="fa-solid fa-volleyball text-white text-sm"></i>
                </div>
                <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    SiGOR <span class="text-slate-900">PKU</span>
                </span>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-500">
                <a href="#cari-lapangan" class="hover:text-blue-600 transition-all flex items-center gap-1.5"><i class="fa-solid fa-magnifying-glass text-xs"></i> Cari GOR</a>
                <a href="#keunggulan" class="hover:text-blue-600 transition-all flex items-center gap-1.5"><i class="fa-solid fa-circle-info text-xs"></i> Keunggulan</a>
                <a href="#cara-sewa" class="hover:text-blue-600 transition-all flex items-center gap-1.5"><i class="fa-solid fa-route text-xs"></i> Cara Sewa</a>
            </nav>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-3">
                @include('components.theme-toggle')
                @if(Auth::guard('web')->check())
                    <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-blue-500/10 text-xs transition-all flex items-center gap-1.5">
                        <i class="fa-solid fa-gauge"></i> Ke Dashboard
                    </a>
                @elseif(Auth::guard('pelanggan')->check())
                    <a href="{{ route('pelanggan.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-blue-500/10 text-xs transition-all flex items-center gap-1.5">
                        <i class="fa-solid fa-gauge"></i> Ke Dashboard
                    </a>
                @elseif(Auth::guard('pemilik')->check())
                    <a href="{{ route('pemilik.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-blue-500/10 text-xs transition-all flex items-center gap-1.5">
                        <i class="fa-solid fa-gauge"></i> Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-blue-600 text-xs font-bold transition-all px-3 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register.pelanggan') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-blue-500/20 text-xs transition-all">
                        Daftar
                    </a>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Wrapper -->
    <main class="flex-grow">
        
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 text-white py-24 px-6 md:px-12 overflow-hidden">
            <!-- Decorative backdrop gradients -->
            <div class="absolute -right-20 -top-20 w-96 h-96 rounded-full bg-blue-600/20 blur-3xl glow-circle"></div>
            <div class="absolute -left-20 -bottom-20 w-96 h-96 rounded-full bg-indigo-600/20 blur-3xl glow-circle"></div>

            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-16 items-center relative z-10">
                
                <!-- Left text content -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <span class="inline-flex items-center gap-1.5 bg-blue-500/15 border border-blue-500/30 text-blue-400 font-bold text-xs uppercase tracking-wider px-4 py-2 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span> ⚡ Portal Booking Lapangan No.1 Pekanbaru
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Pesan Lapangan <span class="bg-gradient-to-r from-blue-400 via-indigo-400 to-violet-400 bg-clip-text text-transparent">Lebih Cepat</span> & Anti Ribet
                    </h1>
                    <p class="text-slate-350 text-sm md:text-base leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Platform marketplace modern yang menghubungkan penyewa dengan gedung olahraga terbaik di Kota Pekanbaru. Pantau ketersediaan slot sewa secara real-time, pilih durasi sewa, lakukan transaksi aman, dan kunci lapangan Anda seketika.
                    </p>
                    <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                        <a href="#cari-lapangan" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3.5 px-8 rounded-2xl shadow-lg shadow-blue-500/20 text-sm transition-all flex items-center gap-2 group">
                            Cari Lapangan Sekarang <i class="fa-solid fa-arrow-down group-hover:translate-y-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('register.pemilik') }}" class="bg-white/5 hover:bg-white/10 text-white border border-white/10 font-bold py-3.5 px-8 rounded-2xl text-sm transition-all flex items-center gap-2">
                            Daftarkan GOR Anda <i class="fa-solid fa-hotel text-slate-400"></i>
                        </a>
                    </div>
                </div>

                <!-- Right dynamic statistics card / Mockup -->
                <div class="lg:col-span-5 flex justify-center float-animation">
                    <div class="glass-card rounded-3xl p-8 w-full max-w-sm space-y-6 shadow-2xl relative">
                        <div class="absolute -top-6 -right-6 w-20 h-20 bg-blue-600/30 rounded-full blur-2xl pointer-events-none"></div>
                        
                        <div class="flex justify-between items-center border-b border-white/10 pb-4">
                            <h3 class="text-sm font-bold flex items-center gap-2">
                                <i class="fa-solid fa-chart-line text-blue-400"></i> Aktivitas SiGOR PKU
                            </h3>
                            <span class="bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase px-2 py-0.5 rounded-full border border-emerald-500/30">Live</span>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Mitra GOR Terverifikasi</span>
                                <h4 class="text-2xl font-extrabold text-white mt-1">{{ count($venues) }} GOR</h4>
                            </div>
                            <div>
                                <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Cabang Olahraga</span>
                                <h4 class="text-2xl font-extrabold text-white mt-1">5 Kategori</h4>
                            </div>
                        </div>

                        <!-- Mock Booking Ticket UI -->
                        <div class="bg-white/5 border border-white/10 rounded-2xl p-4 space-y-3">
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="text-slate-400 font-bold uppercase">Booking Terbaru</span>
                                <span class="text-blue-400 font-semibold">Baru Saja</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-600/20 flex items-center justify-center text-blue-400 text-sm">
                                    <i class="fa-solid fa-shuttlecock"></i>
                                </div>
                                <div class="min-w-0 flex-grow">
                                    <p class="text-xs font-bold truncate">GOR Badminton Angkasa</p>
                                    <p class="text-[10px] text-slate-400 truncate">Lapangan 1 (Synthetic) &bull; 3 Jam</p>
                                </div>
                                <span class="text-xs font-extrabold text-emerald-400">Lunas</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Search and Live Venues Section -->
        <section id="cari-lapangan" class="py-24 px-6 md:px-12 max-w-7xl mx-auto space-y-12 relative">
            <div class="absolute top-1/4 left-10 w-96 h-96 bg-indigo-200/20 rounded-full filter blur-3xl opacity-70 pointer-events-none"></div>
            <div class="absolute top-1/2 right-10 w-96 h-96 bg-purple-200/20 rounded-full filter blur-3xl opacity-50 pointer-events-none"></div>

            <!-- Headline & Search box -->
            <div class="text-center space-y-3">
                <h2 class="text-3xl font-extrabold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Cari & Sewa Lapangan Olahraga</h2>
                <p class="text-slate-500 text-sm max-w-xl mx-auto">Temukan GOR aktif, pilih jadwal sewa langsung, dan nikmati kemudahan bertanding olahraga.</p>
            </div>

            <!-- Glassmorphic Search Form Card -->
            <div class="bg-white border border-slate-100/80 rounded-3xl p-6 shadow-xl shadow-slate-100">
                <form action="#cari-lapangan" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div class="space-y-1.5">
                        <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Cari Nama GOR</label>
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3.5 text-slate-400 text-sm"></i>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: GOR Angkasa..." class="form-input text-xs pl-9">
                        </div>
                    </div>

                    <!-- Kecamatan Dropdown -->
                    <div class="space-y-1.5">
                        <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Filter Kecamatan</label>
                        <select name="kecamatan" class="form-input text-xs">
                            <option value="">Semua Kecamatan</option>
                            @foreach($kecamatans as $kec)
                                <option value="{{ $kec }}" {{ request('kecamatan') === $kec ? 'selected' : '' }}>{{ $kec }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sport Category Dropdown -->
                    <div class="space-y-1.5">
                        <label class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Kategori Cabang Olahraga</label>
                        <select name="jenis" class="form-input text-xs">
                            <option value="">Semua Olahraga</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id_jenis }}" {{ request('jenis') == $cat->id_jenis ? 'selected' : '' }}>{{ $cat->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Form Action buttons -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-grow btn-primary py-2.5 px-4 text-xs font-bold shadow-md shadow-blue-500/20 flex items-center justify-center gap-1.5 transition-all">
                            <i class="fa-solid fa-filter"></i> Cari Lapangan
                        </button>
                        @if(request()->filled('search') || request()->filled('kecamatan') || request()->filled('jenis'))
                            <a href="#cari-lapangan" onclick="window.location.href='/'" class="btn-secondary py-2.5 px-4 text-xs font-bold flex items-center justify-center gap-1.5">
                                <i class="fa-solid fa-rotate-left"></i> Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Venues grid -->
            <div class="space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Gedung Olahraga Terbuka ({{ count($venues) }})</h3>
                    @if(request()->filled('search') || request()->filled('kecamatan') || request()->filled('jenis'))
                        <span class="text-xs text-blue-600 font-bold">Filter Aktif</span>
                    @endif
                </div>
                
                @if($venues->isEmpty())
                    <div class="card p-16 text-center text-slate-400 bg-white border border-slate-100">
                        <i class="fa-solid fa-store-slash text-5xl text-slate-300 mb-4 block animate-bounce"></i>
                        <p class="font-bold text-slate-600">Tidak ada GOR olahraga terverifikasi yang sesuai pencarian.</p>
                        <p class="text-xs text-slate-400 mt-1">Silakan coba kata kunci lain atau gunakan fitur reset filter.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @php
                            $gradients = [
                                'from-teal-500 to-emerald-600',
                                'from-blue-500 to-indigo-600',
                                'from-amber-500 to-orange-600',
                                'from-pink-500 to-rose-600',
                                'from-indigo-500 to-purple-600',
                            ];
                        @endphp
                        @foreach($venues as $venue)
                            @php
                                $minPrice = $venue->lapangans->min('harga_per_jam');
                                $formattedMinPrice = $minPrice ? 'Rp ' . number_format($minPrice, 0, ',', '.') : '-';
                                
                                // Get unique categories
                                $venueCategories = $venue->lapangans->map(function($l) {
                                    return $l->jenisLapangan->nama_jenis ?? null;
                                })->filter()->unique();

                                $isVerified = ($venue->pemilikGor->status_verifikasi ?? 'pending') === 'terverifikasi';
                            @endphp
                            
                            <div class="card bg-white border border-slate-100 flex flex-col justify-between hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden relative group rounded-2xl">
                                <!-- Banner cover with modern gradient design -->
                                <div class="h-44 bg-gradient-to-br {{ $venue->gambar_venue ? 'from-slate-900 to-slate-950' : $gradients[$venue->id_venue % count($gradients)] }} flex items-center justify-center relative overflow-hidden">
                                    @if($venue->gambar_venue)
                                        @if(filter_var($venue->gambar_venue, FILTER_VALIDATE_URL))
                                            <img src="{{ $venue->gambar_venue }}" alt="{{ $venue->nama_venue }}" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <img src="{{ asset('storage/' . $venue->gambar_venue) }}" alt="{{ $venue->nama_venue }}" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-500">
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 to-transparent"></div>
                                    @else
                                        <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-white/10 rounded-full filter blur-xl"></div>
                                        <div class="absolute -left-8 -top-8 w-24 h-24 bg-white/10 rounded-full filter blur-xl"></div>
                                    @endif
                                    
                                    <!-- Dynamic Sport Badges on Cover -->
                                    <div class="absolute top-4 left-4 flex flex-wrap gap-1.5 z-10">
                                        <span class="glass-badge text-white font-bold text-[9px] uppercase tracking-wider px-2.5 py-1 rounded-lg">
                                            {{ $venue->kecamatan }}
                                        </span>
                                        @if($isVerified)
                                            <span class="bg-emerald-500/25 border border-emerald-400/40 text-emerald-250 font-bold text-[9px] uppercase tracking-wider px-2.5 py-1 rounded-lg">
                                                <i class="fa-solid fa-circle-check mr-0.5"></i> Terverifikasi
                                            </span>
                                        @endif
                                        @if($venue->status === 'renovasi')
                                            <span class="bg-amber-500/90 border border-amber-400/50 text-white font-bold text-[9px] uppercase tracking-wider px-2.5 py-1 rounded-lg shadow-sm">
                                                <i class="fa-solid fa-hammer mr-0.5 animate-bounce"></i> Renovasi
                                            </span>
                                        @elseif($venue->status === 'tutup')
                                            <span class="bg-red-650/90 border border-red-500/50 text-white font-bold text-[9px] uppercase tracking-wider px-2.5 py-1 rounded-lg shadow-sm">
                                                <i class="fa-solid fa-door-closed mr-0.5"></i> Tutup
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Sport Icon Watermark -->
                                    <div class="text-white/10 text-9xl absolute -right-6 -bottom-6 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 z-10">
                                        <i class="fa-solid fa-medal"></i>
                                    </div>
                                    
                                    <span class="text-white/20 font-extrabold text-5xl tracking-tighter select-none z-10">SIGor</span>
                                </div>

                                <div class="p-6 space-y-4 flex-grow">
                                    <!-- Venue name & address -->
                                    <div>
                                        <h4 class="text-lg font-bold text-slate-800 transition-all group-hover:text-blue-600" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            {{ $venue->nama_venue }}
                                        </h4>
                                        <p class="text-xs text-slate-500 mt-2 flex items-start gap-1.5 leading-normal">
                                            <i class="fa-solid fa-location-dot mt-0.5 flex-shrink-0 text-slate-400"></i>
                                            <span>{{ $venue->alamat }}</span>
                                        </p>
                                    </div>

                                    <!-- Category Badges -->
                                    <div class="flex flex-wrap gap-1.5 pt-2 border-t border-slate-100">
                                        @foreach($venueCategories as $catName)
                                            <span class="bg-blue-50 text-blue-600 border border-blue-100/50 px-2.5 py-1 rounded-lg text-[9px] font-extrabold uppercase">
                                                {{ $catName }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Footer price & booking action -->
                                <div class="bg-slate-50/80 border-t border-slate-100 p-6 flex items-center justify-between gap-4 mt-auto">
                                    <div>
                                        <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider">Mulai Dari</span>
                                        <span class="text-blue-600 text-base font-extrabold">{{ $formattedMinPrice }}</span> <span class="text-[10px] text-slate-400 font-semibold">/ jam</span>
                                    </div>
                                    
                                    @if($venue->status === 'renovasi')
                                        <button disabled class="bg-amber-50 border border-amber-200 text-amber-600 py-2.5 px-4 text-xs font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-1 shadow-inner">
                                            <i class="fa-solid fa-hammer text-[10px]"></i> Sedang Renovasi
                                        </button>
                                    @elseif($venue->status === 'tutup')
                                        <button disabled class="bg-slate-100 border border-slate-200 text-slate-500 py-2.5 px-4 text-xs font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-1 shadow-inner">
                                            <i class="fa-solid fa-door-closed text-[10px]"></i> Tutup Sementara
                                        </button>
                                    @else
                                        @auth('pelanggan')
                                            <a href="{{ route('pelanggan.venue.show', $venue->id_venue) }}" class="btn-primary py-2.5 px-4 text-xs font-bold shadow-md shadow-blue-500/10 block text-center transition-all">
                                                Sewa GOR <i class="fa-solid fa-arrow-right ml-1"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}?redirect_error=1" class="btn-primary py-2.5 px-4 text-xs font-bold shadow-md shadow-blue-500/10 block text-center transition-all">
                                                Sewa GOR <i class="fa-solid fa-arrow-right ml-1"></i>
                                            </a>
                                        @endauth
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </section>

        <!-- Keunggulan Section -->
        <section id="keunggulan" class="bg-gradient-to-br from-slate-900 to-indigo-950 text-white py-24 px-6 md:px-12">
            <div class="max-w-7xl mx-auto space-y-16">
                <div class="text-center space-y-3">
                    <h2 class="text-3xl font-extrabold text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Keunggulan Sewa di SiGOR PKU</h2>
                    <p class="text-slate-400 text-sm max-w-xl mx-auto">Kami menghadirkan fitur-fitur marketplace terbaik untuk mempermudah transaksi olahraga Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Keunggulan 1 -->
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-8 space-y-4 hover:bg-white/10 hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600/30 text-blue-400 flex items-center justify-center text-xl shadow-lg shadow-blue-500/5">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white">Sewa Multi-Jam</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">Pilih langsung durasi sewa (1 hingga 4 jam sekali pesan) tanpa perlu melakukan pemesanan berulang kali.</p>
                    </div>

                    <!-- Keunggulan 2 -->
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-8 space-y-4 hover:bg-white/10 hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600/30 text-blue-400 flex items-center justify-center text-xl shadow-lg shadow-blue-500/5">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white">Peta Lokasi Instan</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">Dilengkapi peta interaktif Google Maps untuk memudahkan pencarian rute ke lokasi lapangan olahraga di Pekanbaru.</p>
                    </div>

                    <!-- Keunggulan 3 -->
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-8 space-y-4 hover:bg-white/10 hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600/30 text-blue-400 flex items-center justify-center text-xl shadow-lg shadow-blue-500/5">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white">Proteksi Bentrok Lunas</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">Algoritma proteksi sewa menjamin ketersediaan jam sewa yang adil tanpa risiko double booking.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cara Sewa Section -->
        <section id="cara-sewa" class="py-24 px-6 md:px-12 max-w-7xl mx-auto space-y-16">
            <div class="text-center space-y-3">
                <h2 class="text-3xl font-extrabold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">4 Langkah Mudah Menyewa Lapangan</h2>
                <p class="text-slate-500 text-sm max-w-xl mx-auto">Ikuti panduan mudah di bawah ini untuk mulai menyewa lapangan favorit Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="text-center space-y-3 relative group">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto text-2xl font-bold shadow-md shadow-slate-100 group-hover:bg-blue-600 group-hover:text-white transition-all duration-350">
                        1
                    </div>
                    <h5 class="font-bold text-slate-800 text-sm">Cari GOR</h5>
                    <p class="text-xs text-slate-400 leading-relaxed px-4">Temukan GOR Pekanbaru terbaik dengan filter kecamatan dan kategori olahraga.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center space-y-3 relative group">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto text-2xl font-bold shadow-md shadow-slate-100 group-hover:bg-blue-600 group-hover:text-white transition-all duration-350">
                        2
                    </div>
                    <h5 class="font-bold text-slate-800 text-sm">Pilih Jadwal & Durasi</h5>
                    <p class="text-xs text-slate-400 leading-relaxed px-4">Login ke sistem, pilih jam mulai sewa dan durasi jam sewa yang Anda inginkan.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center space-y-3 relative group">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto text-2xl font-bold shadow-md shadow-slate-100 group-hover:bg-blue-600 group-hover:text-white transition-all duration-350">
                        3
                    </div>
                    <h5 class="font-bold text-slate-800 text-sm">Transfer & Upload</h5>
                    <p class="text-xs text-slate-400 leading-relaxed px-4">Kirim pembayaran transfer bank lalu upload bukti transfer ke platform untuk dikonfirmasi.</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center space-y-3 relative group">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto text-2xl font-bold shadow-md shadow-slate-100 group-hover:bg-blue-600 group-hover:text-white transition-all duration-350">
                        4
                    </div>
                    <h5 class="font-bold text-slate-800 text-sm">Mulai Bertanding!</h5>
                    <p class="text-xs text-slate-400 leading-relaxed px-4">Pembayaran disetujui Pemilik GOR, jadwal terkunci untuk Anda dan siap digunakan.</p>
                </div>
            </div>
        </section>

    </main>

    <!-- Global Footer -->
    <footer class="bg-slate-900 border-t border-slate-850 py-12 text-slate-400 text-xs">
        <div class="max-w-7xl mx-auto space-y-6 px-6 text-center">
            <div class="flex items-center justify-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-volleyball text-white text-xs"></i>
                </div>
                <span class="text-lg font-extrabold text-white">SiGOR <span class="text-blue-500">PKU</span></span>
            </div>
            <p class="text-slate-400 max-w-md mx-auto leading-relaxed">Portal marketplace sewa lapangan olahraga bulu tangkis, futsal, voli, basket, dan mini soccer di Kota Pekanbaru, Riau.</p>
            <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <span>&copy; 2026 SiGOR PKU. Hak Cipta Dilindungi. Pekanbaru, Riau, Indonesia.</span>
                <span class="flex gap-4">
                    <span class="hover:text-slate-350">Kebijakan Privasi</span>
                    <span class="hover:text-slate-350">Syarat & Ketentuan</span>
                </span>
            </div>
        </div>
    </footer>

</body>
</html>
