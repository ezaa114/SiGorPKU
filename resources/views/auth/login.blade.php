<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SiGOR PKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-tr from-[#e8eefc] via-[#f1f8f6] to-[#ebf9f7] min-h-screen flex items-center justify-center p-4">

    <!-- Card Container -->
    <div class="w-full max-w-[440px] bg-[#242424] rounded-[2.5rem] shadow-2xl p-8 sm:p-10 border border-[#2f2f2f] flex flex-col items-center animate-fade-in-up">
        
        <!-- App Logo / Icon -->
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#3b82f6] to-[#10b981] flex items-center justify-center mb-6 shadow-md shadow-blue-500/10">
            <i class="fa-solid fa-volleyball text-white text-2xl animate-bounce"></i>
        </div>

        <!-- Header -->
        <h1 class="text-white text-2xl font-bold tracking-tight text-center">Masuk ke akun</h1>
        <p class="text-slate-400 mt-2 text-sm text-center mb-8">Akses platform pemesanan lapangan olahraga</p>

        <!-- Alerts -->
        @if ($errors->any())
            <div class="bg-[#2d1414] border border-[#441f1f] text-[#f87171] text-xs rounded-xl p-4 flex gap-3 w-full mb-6 leading-relaxed">
                <i class="fa-solid fa-triangle-exclamation text-[#f87171] mt-0.5 text-sm"></i>
                <div>
                    <span class="font-bold block mb-1">Gagal masuk:</span>
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

        @if (session('success'))
            <div class="bg-[#132c1c] border border-[#1c4d2d] text-[#4ade80] text-xs rounded-xl p-4 flex items-center gap-3 w-full mb-6">
                <i class="fa-solid fa-key text-[#4ade80] text-sm"></i>
                <div class="font-medium">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login') }}" method="POST" class="w-full space-y-5">
            @csrf
            
            <!-- Email -->
            <div>
                <label for="email" class="text-slate-300 text-xs font-semibold mb-2 block">Alamat email</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-envelope absolute left-4 text-slate-400 text-sm"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="rengga@demo.com">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="text-slate-300 text-xs font-semibold mb-2 block">Password</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-lock absolute left-4 text-slate-400 text-sm"></i>
                    <input type="password" id="password" name="password" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="••••••••">
                </div>
            </div>

            <!-- Options -->
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" 
                           class="w-4 h-4 text-blue-600 bg-[#2d2d2d] border-[#3d3d3d] rounded focus:ring-blue-500/20 focus:ring-offset-0 focus:outline-none cursor-pointer">
                    <label for="remember" class="ml-2 text-xs text-slate-400 select-none cursor-pointer">Ingat saya</label>
                </div>
                <a href="#" class="text-xs text-blue-400 hover:text-blue-300 hover:underline transition">Lupa password?</a>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full bg-gradient-to-r from-[#3b82f6] to-[#10b981] hover:from-[#2563eb] hover:to-[#059669] text-white font-bold py-3.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-blue-500/10 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-sm mt-2">
                Masuk sekarang
            </button>
        </form>

        <!-- Divider -->
        <div class="relative flex py-5 items-center w-full">
            <div class="flex-grow border-t border-[#3d3d3d]"></div>
            <span class="flex-shrink mx-4 text-slate-500 text-xs lowercase font-medium">belum punya akun?</span>
            <div class="flex-grow border-t border-[#3d3d3d]"></div>
        </div>

        <!-- Register Buttons -->
        <div class="grid grid-cols-2 gap-4 w-full">
            <a href="{{ route('register.pelanggan') }}" 
               class="bg-[#2d2d2d] border border-[#3d3d3d] text-slate-300 hover:bg-[#333] hover:text-white transition duration-200 text-xs py-3 rounded-xl flex items-center justify-center font-bold">
                Daftar pelanggan
            </a>
            <a href="{{ route('register.pemilik') }}" 
               class="bg-[#2d2d2d] border border-[#3d3d3d] text-slate-300 hover:bg-[#333] hover:text-white transition duration-200 text-xs py-3 rounded-xl flex items-center justify-center font-bold">
                Daftar pemilik GOR
            </a>
        </div>

    </div>

</body>
</html>
