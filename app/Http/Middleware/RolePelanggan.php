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
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Silakan login sebagai Pelanggan terlebih dahulu.');
    }
}
