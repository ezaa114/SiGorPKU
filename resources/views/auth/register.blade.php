<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SiGOR PKU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            
            <!-- Tab Switcher -->
            <div class="flex p-1 bg-slate-100 rounded-xl mb-6">
                <button onclick="switchTab('pelanggan')" id="tab-pelanggan" class="flex-1 py-2 text-xs font-bold rounded-lg text-slate-600 transition-all focus:outline-none">
                    <i class="fa-solid fa-user mr-1"></i> Pelanggan
                </button>
                <button onclick="switchTab('pemilik')" id="tab-pemilik" class="flex-1 py-2 text-xs font-bold rounded-lg text-slate-600 transition-all focus:outline-none">
                    <i class="fa-solid fa-building mr-1"></i> Pemilik GOR
                </button>
            </div>

            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight" id="register-title" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Akun</h1>
                <p class="text-slate-500 mt-1 text-xs" id="register-subtitle">Buat akun untuk memesan lapangan olahraga</p>
            </div>

            <!-- Error Alerts -->
            @if ($errors->any())
                <div class="alert alert-error mb-6">
                    <ul class="list-disc list-inside text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Pelanggan Form -->
            <form id="form-pelanggan" action="{{ route('register.pelanggan') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="nama_pelanggan" class="form-label text-xs">Nama Lengkap</label>
                    <input type="text" id="nama_pelanggan" name="nama" value="{{ old('nama') }}" required class="form-input text-xs" placeholder="Budi Santoso">
                </div>

                <div>
                    <label for="telp_pelanggan" class="form-label text-xs">Nomor Telepon</label>
                    <input type="text" id="telp_pelanggan" name="no_telepon" value="{{ old('no_telepon') }}" required class="form-input text-xs" placeholder="0812XXXXXXXX">
                </div>

                <div>
                    <label for="email_pelanggan" class="form-label text-xs">Alamat Email</label>
                    <input type="email" id="email_pelanggan" name="email" value="{{ old('email') }}" required class="form-input text-xs" placeholder="budi@example.com">
                </div>

                <div>
                    <label for="pass_pelanggan" class="form-label text-xs">Password</label>
                    <input type="password" id="pass_pelanggan" name="password" required class="form-input text-xs" placeholder="Minimal 6 karakter">
                </div>

                <div>
                    <label for="confirm_pelanggan" class="form-label text-xs">Konfirmasi Password</label>
                    <input type="password" id="confirm_pelanggan" name="password_confirmation" required class="form-input text-xs" placeholder="Ulangi password">
                </div>

                <button type="submit" class="w-full btn-primary py-3 text-sm font-bold shadow-lg shadow-blue-500/20">
                    Daftar Sebagai Pelanggan
                </button>
            </form>

            <!-- Pemilik Form -->
            <form id="form-pemilik" action="{{ route('register.pemilik') }}" method="POST" class="space-y-4 hidden">
                @csrf
                <div>
                    <label for="nama_pemilik" class="form-label text-xs">Nama Lengkap Pemilik</label>
                    <input type="text" id="nama_pemilik" name="nama" value="{{ old('nama') }}" required class="form-input text-xs" placeholder="Ahmad Fauzi">
                </div>

                <div>
                    <label for="nama_usaha" class="form-label text-xs">Nama Usaha / GOR</label>
                    <input type="text" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha') }}" required class="form-input text-xs" placeholder="Contoh: GOR Harapan Baru">
                </div>

                <div>
                    <label for="telp_pemilik" class="form-label text-xs">Nomor Telepon Pemilik</label>
                    <input type="text" id="telp_pemilik" name="no_telepon" value="{{ old('no_telepon') }}" required class="form-input text-xs" placeholder="08XXXXXXXXXX">
                </div>

                <div>
                    <label for="email_pemilik" class="form-label text-xs">Alamat Email Usaha</label>
                    <input type="email" id="email_pemilik" name="email" value="{{ old('email') }}" required class="form-input text-xs" placeholder="pemilik@example.com">
                </div>

                <div>
                    <label for="pass_pemilik" class="form-label text-xs">Password</label>
                    <input type="password" id="pass_pemilik" name="password" required class="form-input text-xs" placeholder="Minimal 6 karakter">
                </div>

                <div>
                    <label for="confirm_pemilik" class="form-label text-xs">Konfirmasi Password</label>
                    <input type="password" id="confirm_pemilik" name="password_confirmation" required class="form-input text-xs" placeholder="Ulangi password">
                </div>

                <div class="bg-amber-50 border border-amber-100 text-amber-800 text-[10px] rounded-lg p-3 leading-relaxed">
                    <strong>Catatan Verifikasi:</strong> Akun Pemilik GOR membutuhkan persetujuan/verifikasi Administrator sebelum venue Anda tampil publik.
                </div>

                <button type="submit" class="w-full btn-primary py-3 text-sm font-bold shadow-lg shadow-blue-500/20">
                    Daftar Sebagai Pemilik GOR
                </button>
            </form>

            <div class="text-center mt-6 text-xs text-slate-500">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Masuk disini</a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-6 text-center text-xs text-slate-400 font-medium">
        &copy; 2026 SiGOR PKU. Hak Cipta Dilindungi. Pekanbaru, Riau.
    </footer>

    <script>
        function switchTab(role) {
            const tabPelanggan = document.getElementById('tab-pelanggan');
            const tabPemilik = document.getElementById('tab-pemilik');
            const formPelanggan = document.getElementById('form-pelanggan');
            const formPemilik = document.getElementById('form-pemilik');
            const title = document.getElementById('register-title');
            const subtitle = document.getElementById('register-subtitle');

            if (role === 'pelanggan') {
                tabPelanggan.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                tabPelanggan.classList.remove('text-slate-600');
                tabPemilik.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                tabPemilik.classList.add('text-slate-600');

                formPelanggan.classList.remove('hidden');
                formPemilik.classList.add('hidden');

                title.innerText = 'Daftar Pelanggan';
                subtitle.innerText = 'Buat akun untuk mulai memesan lapangan olahraga';
            } else {
                tabPemilik.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                tabPemilik.classList.remove('text-slate-600');
                tabPelanggan.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                tabPelanggan.classList.add('text-slate-600');

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
