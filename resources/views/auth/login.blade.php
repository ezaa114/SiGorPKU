<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SiGOR PKU</title>
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
            <span class="text-sm text-slate-500 font-medium hidden sm:inline">Portal Lapangan Olahraga Pekanbaru</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 p-8 transition-all hover:shadow-2xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Masuk ke Akun</h1>
                <p class="text-slate-500 mt-2 text-sm">Akses platform pemesanan lapangan olahraga</p>
            </div>

            <!-- Error Alerts -->
            @if ($errors->any())
                <div class="alert alert-error mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="contoh@domain.com">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="form-label mb-0">Password</label>
                    </div>
                    <input type="password" id="password" name="password" required class="form-input" placeholder="••••••••">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-slate-600 select-none">Ingat saya</label>
                </div>

                <button type="submit" class="w-full btn-primary py-3 text-base shadow-lg shadow-blue-500/20">
                    Masuk Sekarang
                </button>
            </form>

            <div class="relative flex py-5 items-center">
                <div class="flex-grow border-t border-slate-100"></div>
                <span class="flex-shrink mx-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">Belum Punya Akun?</span>
                <div class="flex-grow border-t border-slate-100"></div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('register.pelanggan') }}" class="btn-secondary py-2.5 text-center text-xs justify-center flex font-semibold">
                    Daftar Pelanggan
                </a>
                <a href="{{ route('register.pemilik') }}" class="btn-secondary py-2.5 text-center text-xs justify-center flex font-semibold">
                    Daftar Pemilik GOR
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
