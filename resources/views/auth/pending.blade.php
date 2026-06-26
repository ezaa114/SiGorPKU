<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Menunggu Verifikasi - SiGOR PKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-100 py-4 px-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center gap-2">
                <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    SiGOR <span class="text-slate-900">PKU</span>
                </span>
            </a>
            <a href="{{ route('logout') }}" class="btn-secondary py-1.5 px-4 text-xs font-semibold">
                Keluar / Logout
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-slate-100 p-10 text-center transition-all hover:shadow-2xl">
            
            <!-- Icon pending -->
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-amber-100 text-amber-600 mb-6">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pendaftaran Sedang Ditinjau</h1>
            
            <p class="text-slate-600 mb-6 leading-relaxed">
                Halo, <strong class="text-slate-900">{{ Auth::guard('pemilik')->user()->nama }}</strong>! Pendaftaran usaha/GOR Anda (<strong class="text-slate-900">{{ Auth::guard('pemilik')->user()->nama_usaha }}</strong>) telah kami terima dan saat ini sedang dalam proses review oleh Administrator.
            </p>

            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 text-left space-y-2 mb-8">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-medium">Status Pendaftaran:</span>
                    <span class="badge badge-warning">Pending / Menunggu</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-medium">Email Terdaftar:</span>
                    <span class="text-slate-700 font-semibold">{{ Auth::guard('pemilik')->user()->email }}</span>
                </div>
            </div>

            <p class="text-xs text-slate-400">
                Silakan lakukan refresh halaman secara berkala atau hubungi Admin jika proses verifikasi memakan waktu lebih dari 1x24 jam.
            </p>

            <div class="mt-8 flex justify-center gap-4">
                <button onclick="window.location.reload();" class="btn-primary py-2.5 px-6 font-semibold">
                    Refresh Status
                </button>
                <a href="{{ route('logout') }}" class="btn-secondary py-2.5 px-6 font-semibold">
                    Kembali ke Login
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-6 text-center text-xs text-slate-400 font-medium">
        &copy; 2026 SiGOR PKU. Hak Cipta Dilindungi. Pekanbaru, Riau.
    </footer>

</body>
</html>
