<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SiGOR PKU</title>
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
    <div class="w-full max-w-[480px] bg-[#242424] rounded-[2.5rem] shadow-2xl p-8 sm:p-10 border border-[#2f2f2f] flex flex-col items-center animate-fade-in-up">
        
        <!-- App Logo / Icon -->
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-[#3b82f6] to-[#10b981] flex items-center justify-center mb-6 shadow-md shadow-blue-500/10">
            <i class="fa-solid fa-volleyball text-white text-2xl animate-bounce"></i>
        </div>

        <!-- Tab Switcher -->
        <div class="flex p-1 bg-[#2d2d2d] border border-[#3d3d3d] rounded-xl mb-6 w-full">
            <button onclick="switchTab('pelanggan')" id="tab-pelanggan" class="flex-1 py-2.5 text-xs font-bold rounded-lg text-slate-400 transition-all focus:outline-none cursor-pointer">
                <i class="fa-solid fa-user mr-1"></i> Pelanggan
            </button>
            <button onclick="switchTab('pemilik')" id="tab-pemilik" class="flex-1 py-2.5 text-xs font-bold rounded-lg text-slate-400 transition-all focus:outline-none cursor-pointer">
                <i class="fa-solid fa-building mr-1"></i> Pemilik GOR
            </button>
        </div>

        <!-- Header -->
        <div class="text-center mb-6 w-full">
            <h1 class="text-white text-2xl font-bold tracking-tight text-center" id="register-title">Daftar Akun</h1>
            <p class="text-slate-400 mt-2 text-xs text-center" id="register-subtitle">Buat akun untuk memesan lapangan olahraga</p>
        </div>

        <!-- Error Alerts -->
        @if ($errors->any())
            <div class="bg-[#2d1414] border border-[#441f1f] text-[#f87171] text-xs rounded-xl p-4 flex gap-3 w-full mb-6 leading-relaxed">
                <i class="fa-solid fa-triangle-exclamation text-[#f87171] mt-0.5 text-sm"></i>
                <div>
                    <span class="font-bold block mb-1">Gagal mendaftar:</span>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Pelanggan Form -->
        <form id="form-pelanggan" action="{{ route('register.pelanggan') }}" method="POST" class="w-full space-y-4">
            @csrf
            <div>
                <label for="nama_pelanggan" class="text-slate-300 text-xs font-semibold mb-2 block">Nama Lengkap</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-user absolute left-4 text-slate-400 text-sm"></i>
                    <input type="text" id="nama_pelanggan" name="nama" value="{{ old('nama') }}" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="Budi Santoso">
                </div>
            </div>

            <div>
                <label for="telp_pelanggan" class="text-slate-300 text-xs font-semibold mb-2 block">Nomor Telepon</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-phone absolute left-4 text-slate-400 text-sm"></i>
                    <input type="text" id="telp_pelanggan" name="no_telepon" value="{{ old('no_telepon') }}" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="0812XXXXXXXX">
                </div>
            </div>

            <div>
                <label for="email_pelanggan" class="text-slate-300 text-xs font-semibold mb-2 block">Alamat Email</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-envelope absolute left-4 text-slate-400 text-sm"></i>
                    <input type="email" id="email_pelanggan" name="email" value="{{ old('email') }}" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="budi@example.com">
                </div>
            </div>

            <div>
                <label for="pass_pelanggan" class="text-slate-300 text-xs font-semibold mb-2 block">Password</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-lock absolute left-4 text-slate-400 text-sm"></i>
                    <input type="password" id="pass_pelanggan" name="password" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="Minimal 6 karakter">
                </div>
            </div>

            <div>
                <label for="confirm_pelanggan" class="text-slate-300 text-xs font-semibold mb-2 block">Konfirmasi Password</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-check-double absolute left-4 text-slate-400 text-sm"></i>
                    <input type="password" id="confirm_pelanggan" name="password_confirmation" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="Ulangi password">
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-[#3b82f6] to-[#10b981] hover:from-[#2563eb] hover:to-[#059669] text-white font-bold py-3.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-blue-500/10 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-xs mt-2">
                Daftar Sebagai Pelanggan
            </button>
        </form>

        <!-- Pemilik Form -->
        <form id="form-pemilik" action="{{ route('register.pemilik') }}" method="POST" class="w-full space-y-4 hidden">
            @csrf
            <div>
                <label for="nama_pemilik" class="text-slate-300 text-xs font-semibold mb-2 block">Nama Lengkap Pemilik</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-user absolute left-4 text-slate-400 text-sm"></i>
                    <input type="text" id="nama_pemilik" name="nama" value="{{ old('nama') }}" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="Ahmad Fauzi">
                </div>
            </div>

            <div>
                <label for="nama_usaha" class="text-slate-300 text-xs font-semibold mb-2 block">Nama Usaha / GOR</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-store absolute left-4 text-slate-400 text-sm"></i>
                    <input type="text" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha') }}" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="Contoh: GOR Harapan Baru">
                </div>
            </div>

            <div>
                <label for="telp_pemilik" class="text-slate-300 text-xs font-semibold mb-2 block">Nomor Telepon Pemilik</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-phone absolute left-4 text-slate-400 text-sm"></i>
                    <input type="text" id="telp_pemilik" name="no_telepon" value="{{ old('no_telepon') }}" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="08XXXXXXXXXX">
                </div>
            </div>

            <div>
                <label for="email_pemilik" class="text-slate-300 text-xs font-semibold mb-2 block">Alamat Email Usaha</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-envelope absolute left-4 text-slate-400 text-sm"></i>
                    <input type="email" id="email_pemilik" name="email" value="{{ old('email') }}" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="pemilik@example.com">
                </div>
            </div>

            <div>
                <label for="pass_pemilik" class="text-slate-300 text-xs font-semibold mb-2 block">Password</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-lock absolute left-4 text-slate-400 text-sm"></i>
                    <input type="password" id="pass_pemilik" name="password" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="Minimal 6 karakter">
                </div>
            </div>

            <div>
                <label for="confirm_pemilik" class="text-slate-300 text-xs font-semibold mb-2 block">Konfirmasi Password</label>
                <div class="relative flex items-center">
                    <i class="fa-solid fa-check-double absolute left-4 text-slate-400 text-sm"></i>
                    <input type="password" id="confirm_pemilik" name="password_confirmation" required 
                           class="w-full bg-[#2d2d2d] border border-[#3d3d3d] text-white placeholder-slate-500 rounded-xl pl-11 pr-4 py-3 text-xs focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition" 
                           placeholder="Ulangi password">
                </div>
            </div>

            <div class="bg-[#2d2514] border border-[#44381f] text-[#f59e0b] text-[10px] rounded-xl p-3.5 leading-relaxed">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i> <strong>Catatan Verifikasi:</strong> Akun Pemilik GOR membutuhkan persetujuan/verifikasi Administrator sebelum GOR Anda tampil ke publik.
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-[#3b82f6] to-[#10b981] hover:from-[#2563eb] hover:to-[#059669] text-white font-bold py-3.5 px-4 rounded-xl transition duration-200 shadow-lg shadow-blue-500/10 focus:outline-none focus:ring-2 focus:ring-blue-500/20 text-xs mt-2">
                Daftar Sebagai Pemilik GOR
            </button>
        </form>

        <div class="text-center mt-6 text-xs text-slate-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold hover:underline transition">Masuk disini</a>
        </div>
    </div>

    <script>
        function switchTab(role) {
            const tabPelanggan = document.getElementById('tab-pelanggan');
            const tabPemilik = document.getElementById('tab-pemilik');
            const formPelanggan = document.getElementById('form-pelanggan');
            const formPemilik = document.getElementById('form-pemilik');
            const title = document.getElementById('register-title');
            const subtitle = document.getElementById('register-subtitle');

            if (role === 'pelanggan') {
                tabPelanggan.classList.add('bg-[#3c3c3c]', 'text-white', 'shadow-sm');
                tabPelanggan.classList.remove('text-slate-400');
                tabPemilik.classList.remove('bg-[#3c3c3c]', 'text-white', 'shadow-sm');
                tabPemilik.classList.add('text-slate-400');

                formPelanggan.classList.remove('hidden');
                formPemilik.classList.add('hidden');

                title.innerText = 'Daftar Pelanggan';
                subtitle.innerText = 'Buat akun untuk mulai memesan lapangan olahraga';
            } else {
                tabPemilik.classList.add('bg-[#3c3c3c]', 'text-white', 'shadow-sm');
                tabPemilik.classList.remove('text-slate-400');
                tabPelanggan.classList.remove('bg-[#3c3c3c]', 'text-white', 'shadow-sm');
                tabPelanggan.classList.add('text-slate-400');

                formPemilik.classList.remove('hidden');
                formPelanggan.classList.add('hidden');

                title.innerText = 'Daftar Pemilik GOR';
                subtitle.innerText = 'Daftarkan usaha Anda dan kelola penyewaan lapangan';
            }
        }

        // Initialize default tab
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const role = urlParams.get('role') || 'pelanggan';
            switchTab(role);
        });
    </script>

</body>
</html>
