<?php

namespace App\Http\Controllers;

use App\Models\K3lkEmployee;
use Illuminate\Http\Request;

class K3lkEmployeeController extends Controller
{
    // Menampilkan daftar pegawai K3LK
    public function index()
    {
        $pegawai = K3lkEmployee::latest()->get();
        return view('k3lk_employees.index', compact('pegawai'));
    }

    // Menampilkan form tambah pegawai
    public function create()
    {
        return view('k3lk_employees.create');
    }

    // Menyimpan data pegawai baru ke database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:k3lk_employees,nip',
            'nama_pegawai' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        K3lkEmployee::create($validated);

        return redirect()->route('k3lk_employees.index')
                         ->with('success', 'Data Pegawai K3LK berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit pegawai
     */
    public function edit(K3lkEmployee $k3lk_employee)
    {
        return view('k3lk_employees.edit', compact('k3lk_employee'));
    }

    /**
     * Memproses pembaruan data pegawai
     */
    public function update(Request $request, K3lkEmployee $k3lk_employee)
    {
        $validated = $request->validate([
            // Unik NIP dikecualikan untuk ID pegawai yang sedang diedit
            'nip' => 'required|unique:k3lk_employees,nip,' . $k3lk_employee->id,
            'nama_pegawai' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        $k3lk_employee->update($validated);

        return redirect()->route('k3lk_employees.index')
                         ->with('success', 'Data Pegawai K3LK berhasil diperbarui!');
    }

    /**
     * Menghapus data pegawai
     */
    public function destroy(K3lkEmployee $k3lk_employee)
    {
        $k3lk_employee->delete();

        return redirect()->route('k3lk_employees.index')
                         ->with('success', 'Data Pegawai K3LK berhasil dihapus!');
    }
}