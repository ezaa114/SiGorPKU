<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    private function getCurrentGuardInfo()
    {
        if (Auth::guard('web')->check()) {
            return [
                'guard' => 'web',
                'user' => Auth::guard('web')->user(),
                'layout' => 'layouts.admin',
                'role' => 'admin',
                'title' => 'Profil Admin',
                'id_column' => 'id',
                'table' => 'users',
            ];
        } elseif (Auth::guard('pemilik')->check()) {
            return [
                'guard' => 'pemilik',
                'user' => Auth::guard('pemilik')->user(),
                'layout' => 'layouts.pemilik',
                'role' => 'pemilik',
                'title' => 'Profil Pemilik GOR',
                'id_column' => 'id_pemilik',
                'table' => 'pemilik_gors',
            ];
        } elseif (Auth::guard('pelanggan')->check()) {
            return [
                'guard' => 'pelanggan',
                'user' => Auth::guard('pelanggan')->user(),
                'layout' => 'layouts.pelanggan',
                'role' => 'pelanggan',
                'title' => 'Profil Saya',
                'id_column' => 'id_pelanggan',
                'table' => 'pelanggan',
            ];
        }

        abort(403, 'Unauthorized.');
    }

    public function edit()
    {
        $info = $this->getCurrentGuardInfo();
        $user = $info['user'];
        $layout = $info['layout'];
        $role = $info['role'];
        $title = $info['title'];

        return view('profile.edit', compact('user', 'layout', 'role', 'title'));
    }

    public function update(Request $request)
    {
        $info = $this->getCurrentGuardInfo();
        $user = $info['user'];
        $role = $info['role'];
        $idColumn = $info['id_column'];
        $userId = $user->{$idColumn};

        $rules = [
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique($info['table'], 'email')->ignore($userId, $idColumn),
            ],
            'password' => 'nullable|string|min:6|confirmed',
        ];

        if ($role === 'admin') {
            $rules['name'] = 'required|string|max:150';
        } else {
            $rules['nama'] = 'required|string|max:100';
            $rules['no_telepon'] = 'nullable|string|max:20';
        }

        if ($role === 'pemilik') {
            $rules['nama_usaha'] = 'required|string|max:150';
        }

        $request->validate($rules);

        $data = [];
        if ($role === 'admin') {
            $data['name'] = $request->name;
        } else {
            $data['nama'] = $request->nama;
            $data['no_telepon'] = $request->no_telepon;
        }

        if ($role === 'pemilik') {
            $data['nama_usaha'] = $request->nama_usaha;
        }

        $data['email'] = $request->email;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
