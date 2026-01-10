<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Middleware 'role:admin' diterapkan untuk semua fungsi,
     * KECUALI fungsi 'switchRole' dan 'impersonate' agar kita bisa pindah akun/role bolak-balik.
     */
    public function __construct()
    {
        $this->middleware('role:admin')->except(['switchRole', 'impersonate']);
    }

    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan form edit user
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update role user secara manual
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Data User berhasil diperbarui!');
    }

    /**
     * FITUR BARU: Pindah Role Cepat (Testing)
     * Fungsi ini akan membalikkan role user yang sedang login.
     */
    public function switchRole(Request $request)
    {
        $user = Auth::user();
        
        // Logika: Jika Admin ganti ke User, Jika User ganti ke Admin
        $newRole = ($user->role === 'admin') ? 'user' : 'admin';
        
        // Update ke database
        $user->update([
            'role' => $newRole
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Berhasil pindah ke mode: ' . strtoupper($newRole));
    }

    /**
     * FITUR BARU: Loncat Akun (Impersonate)
     * Digunakan untuk pindah akun secara instan tanpa logout/ketik password.
     */
    public function impersonate($id)
    {
        // Cari user berdasarkan ID yang dituju
        $user = User::findOrFail($id);

        // Langsung paksa login ke akun tersebut tanpa password
        Auth::login($user);

        // Redirect ke dashboard
        return redirect()->route('dashboard')->with('success', 'Anda sekarang login sebagai: ' . $user->name);
    }
}