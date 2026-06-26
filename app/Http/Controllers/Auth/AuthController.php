<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\PemilikGor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if ($request->has('redirect_error')) {
            session()->flash('error', 'Silakan login sebagai Pelanggan terlebih dahulu untuk melihat detail jadwal dan menyewa lapangan.');
        }

        // If already logged in, redirect to respective dashboard
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('pelanggan')->check()) {
            return redirect()->route('pelanggan.dashboard');
        }
        if (Auth::guard('pemilik')->check()) {
            $pemilik = Auth::guard('pemilik')->user();
            if ($pemilik->status_verifikasi === 'pending') {
                return redirect()->route('pemilik.pending');
            }
            return redirect()->route('pemilik.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 1. Coba Admin (guard web)
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
        }

        // 2. Coba Pelanggan
        if (Auth::guard('pelanggan')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('pelanggan.dashboard')->with('success', 'Login berhasil!');
        }

        // 3. Coba Pemilik GOR
        if (Auth::guard('pemilik')->attempt($credentials, $request->boolean('remember'))) {
            $pemilik = Auth::guard('pemilik')->user();
            $request->session()->regenerate();

            if ($pemilik->status_verifikasi === 'pending') {
                return redirect()->route('pemilik.pending');
            }

            if ($pemilik->status_verifikasi === 'ditolak') {
                Auth::guard('pemilik')->logout();
                return back()->withErrors(['email' => 'Pendaftaran Pemilik GOR Anda telah ditolak oleh Admin.']);
            }

            return redirect()->route('pemilik.dashboard')->with('success', 'Selamat datang, Pemilik GOR!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function showRegisterPelanggan()
    {
        return view('auth.register');
    }

    public function registerPelanggan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|string|email|max:100|unique:pelanggan,email|unique:pemilik_gors,email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('pelanggan')->login($pelanggan);

        return redirect()->route('pelanggan.dashboard')->with('success', 'Registrasi berhasil dan Anda telah masuk!');
    }

    public function showRegisterPemilik()
    {
        return view('auth.register');
    }

    public function registerPemilik(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'no_telepon' => 'required|string|max:20',
            'nama_usaha' => 'required|string|max:150',
            'email' => 'required|string|email|max:100|unique:pelanggan,email|unique:pemilik_gors,email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $pemilik = PemilikGor::create([
            'nama' => $request->nama,
            'no_telepon' => $request->no_telepon,
            'nama_usaha' => $request->nama_usaha,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status_verifikasi' => 'pending',
        ]);

        Auth::guard('pemilik')->login($pemilik);

        return redirect()->route('pemilik.pending');
    }

    public function pendingPemilik()
    {
        if (!Auth::guard('pemilik')->check()) {
            return redirect()->route('login');
        }

        $pemilik = Auth::guard('pemilik')->user();
        
        if ($pemilik->status_verifikasi === 'terverifikasi') {
            return redirect()->route('pemilik.dashboard');
        }

        return view('auth.pending');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        } elseif (Auth::guard('pelanggan')->check()) {
            Auth::guard('pelanggan')->logout();
        } elseif (Auth::guard('pemilik')->check()) {
            Auth::guard('pemilik')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // 1. Cari di Pelanggan
        $pelanggan = Pelanggan::where('email', $request->email)->first();
        if ($pelanggan) {
            $pelanggan->password = Hash::make($request->password);
            $pelanggan->save();
            return redirect()->route('login')->with('success', 'Password Pelanggan berhasil direset! Silakan login.');
        }

        // 2. Cari di Pemilik GOR
        $pemilik = PemilikGor::where('email', $request->email)->first();
        if ($pemilik) {
            $pemilik->password = Hash::make($request->password);
            $pemilik->save();
            return redirect()->route('login')->with('success', 'Password Pemilik GOR berhasil direset! Silakan login.');
        }

        // 3. Cari di Admin (User)
        $admin = \App\Models\User::where('email', $request->email)->first();
        if ($admin) {
            $admin->password = Hash::make($request->password);
            $admin->save();
            return redirect()->route('login')->with('success', 'Password Admin berhasil direset! Silakan login.');
        }

        return back()->withErrors(['email' => 'Alamat email tidak terdaftar di sistem kami.'])->withInput();
    }
}
