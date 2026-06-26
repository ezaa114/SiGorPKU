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
    <title>Lupa Password - SiGOR PKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }
    </style>
</head>
<body class="auth-body bg-gradient-to-tr from-[#e8eefc] via-[#f1f8f6] to-[#ebf9f7] min-h-screen flex items-center justify-center p-4 relative">

    <!-- Theme Toggle absolute position -->
    <div class="absolute top-6 right-6">
        @include('components.theme-toggle')
    </div>

    <!-- Card Container -->
    <div class="w-full max-w-[440px] auth-card rounded-[2.5rem] shadow-2xl p-8 sm:p-10 border flex flex-col items-center animate-fade-in-up">
        
        <!-- App Logo / Icon -->
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#3b82f6] to-[#10b981] flex items-center justify-center mb-6 shadow-md shadow-blue-500/10">
            <i class="fa-solid fa-volleyball text-white text-2xl animate-bounce"></i>
        </div>

        <!-- Header -->
        <h1 class="auth-title text-2xl font-bold tracking-tight text-center">Lupa Password</h1>
        <p class="auth-subtitle mt-2 text-sm text-center mb-8">Atur ulang password akun SiGOR PKU Anda</p>

        <!-- Alerts -->
        @if ($errors->any())
            <div class="bg-[#2d1414] border border-[#441f1f] text-[#f87171] text-xs rounded-xl p-4 flex gap-3 w-full mb-6 leading-relaxed">
                <i class="fa-solid fa-triangle-exclamation text-[#f87171] mt-0.5 text-sm"></i>
                <div>
                    <span class="font-bold block mb-1">Gagal atur ulang:</span>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-[#2d1414] border border-[#441f1f] text-[#f87171] text-xs rounded-xl p-4 flex gap-3 w-full mb-6 leading-relaxed">
                <i class="fa-solid fa-triangle-exclamation text-[#f87171] mt-0.5 text-sm"></i>
                <div>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('password.update') }}" method="POST" class="w-full space-y-5">
            @csrf
            
            <!-- Email -->
            <div>
                <label for="email" class="auth-label text-xs font-semibold mb-2 block">Alamat email terdaftar</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-envelope absolute left-4 text-slate-400 text-sm"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                           class="w-full auth-input border rounded-xl pl-11 pr-4 py-3.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="Masukkan email Anda">
                </div>
            </div>

            <!-- Password Baru -->
            <div>
                <label for="password" class="auth-label text-xs font-semibold mb-2 block">Password Baru</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-lock absolute left-4 text-slate-400 text-sm"></i>
                    <input type="password" id="password" name="password" required 
                           class="w-full auth-input border rounded-xl pl-11 pr-4 py-3.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="Minimal 6 karakter">
                </div>
            </div>

            <!-- Konfirmasi Password Baru -->
            <div>
                <label for="password_confirmation" class="auth-label text-xs font-semibold mb-2 block">Konfirmasi Password Baru</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-check-double absolute left-4 text-slate-400 text-sm"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" required 
                           class="w-full auth-input border rounded-xl pl-11 pr-4 py-3.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="Ulangi password baru">
                </div>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-gradient-to-r from-[#3b82f6] to-[#10b981] hover:from-[#2563eb] hover:to-[#059669] text-white font-bold py-3.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-blue-500/10 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-sm mt-2">
                Atur Ulang Password
            </button>
        </form>

        <!-- Back to Login Link -->
        <div class="text-center mt-6 text-xs auth-checkbox-label">
            Sudah ingat password? <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold hover:underline transition">Masuk disini</a>
        </div>

    </div>

</body>
</html>
