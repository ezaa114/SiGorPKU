<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolePemilikGor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('pemilik')->check()) {
            $pemilik = Auth::guard('pemilik')->user();
            if ($pemilik->status_verifikasi === 'terverifikasi') {
                return $next($request);
            }
            
            if ($pemilik->status_verifikasi === 'pending') {
                if (!$request->routeIs('pemilik.pending') && !$request->routeIs('logout')) {
                    return redirect()->route('pemilik.pending');
                }
                return $next($request);
            }

            if ($pemilik->status_verifikasi === 'ditolak') {
                Auth::guard('pemilik')->logout();
                return redirect()->route('login')->with('error', 'Pendaftaran Pemilik GOR Anda telah ditolak oleh Admin.');
            }
        }

        return redirect()->route('login')->with('error', 'Silakan login sebagai Pemilik GOR terlebih dahulu.');
    }
}
