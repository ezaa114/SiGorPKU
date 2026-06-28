<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolePelanggan
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('pelanggan')->check()) {
            $pelanggan = Auth::guard('pelanggan')->user();
            if ($pelanggan->status === 'diblokir') {
                Auth::guard('pelanggan')->logout();
                return redirect()->route('login')->withErrors(['email' => 'Akun Anda telah diblokir oleh Admin.']);
            }
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Silakan login sebagai Pelanggan terlebih dahulu.');
    }
}
