@extends($layout)

@section('title', $title)
@section('header_title', $title)

@section('content')
<div class="max-w-xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Profile Card -->
    <div class="card p-8 bg-white border border-slate-100 shadow-sm rounded-2xl">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold uppercase shadow-md shadow-blue-500/20">
                @if($role === 'admin')
                    {{ substr($user->name ?? 'A', 0, 1) }}
                @else
                    {{ substr($user->nama ?? 'U', 0, 1) }}
                @endif
            </div>
            <div>
                <h3 class="text-xl font-extrabold text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    @if($role === 'admin')
                        {{ $user->name }}
                    @else
                        {{ $user->nama }}
                    @endif
                </h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mt-0.5">{{ $role }}</p>
            </div>
        </div>

        <!-- Form Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-error mb-6">
                <ul class="list-disc list-inside text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route($role . '.profile.update') }}" method="POST" class="space-y-5">
            @csrf
            
            @if($role === 'admin')
                <div>
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="form-input" placeholder="Masukkan nama lengkap Anda">
                </div>
            @else
                <div>
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required class="form-input" placeholder="Masukkan nama lengkap Anda">
                </div>
            @endif

            @if($role === 'pemilik')
                <div>
                    <label for="nama_usaha" class="form-label">Nama Usaha / Bisnis GOR</label>
                    <input type="text" id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha', $user->nama_usaha) }}" required class="form-input" placeholder="Nama GOR/Bisnis Anda">
                </div>
            @endif

            <div>
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input" placeholder="contoh@domain.com">
            </div>

            @if($role !== 'admin')
                <div>
                    <label for="no_telepon" class="form-label">Nomor Telepon / WhatsApp</label>
                    <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" class="form-input" placeholder="Contoh: 0812XXXXXXXX">
                </div>
            @endif

            <div class="border-t border-slate-100 pt-5 mt-5">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Ganti Password (Kosongkan jika tidak ingin diubah)</h4>
                
                <div class="space-y-4">
                    <div>
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan password baru minimal 6 karakter">
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full btn-primary py-3 text-sm font-bold shadow-lg shadow-blue-500/20 mt-6">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
