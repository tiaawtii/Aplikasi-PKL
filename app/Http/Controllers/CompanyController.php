<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    // ... (index, create, show) TIDAK BERUBAH ...
    
    public function index()
    {
        // Mengambil semua data perusahaan
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create'); 
    }
    
    public function show(string $id)
    {
        //
    }

    // --- STORE (Simpan Data Baru) ---
    public function store(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:companies,nama', 'regex:/[a-zA-Z]/'], 
            'alamat' => ['nullable', 'string'],
            'kontak' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
        ]);
        
        // 1. BUAT KODE UNIK SEBELUM DISIMPAN
        $uniqueCode = Company::generateUniqueCode($request->nama);
        
        // 2. Gabungkan kode ke data request
        $data = $request->all();
        $data['kode_perusahaan'] = $uniqueCode;

        // 3. Simpan Data ke Database
        Company::create($data);

        return Redirect::route('companies.index')->with('success', 'Data Perusahaan Pelaksana berhasil ditambahkan!');
    }

    // --- UPDATE (Perbarui Data) ---
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:companies,nama,' . $company->id, 'regex:/[a-zA-Z]/'], 
            'alamat' => ['nullable', 'string'],
            'kontak' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
        ]);

        $company->update($request->all());

        // KODE TIDAK PERLU DIBUAT ULANG SAAT UPDATE, HANYA NAMA PT YANG BERUBAH
        // Jika Anda ingin kode berubah saat nama PT diubah, tambahkan logika ini:
        /*
        if ($company->isDirty('nama')) {
             $uniqueCode = Company::generateUniqueCode($request->nama);
             $company->kode_perusahaan = $uniqueCode;
             $company->save();
        }
        */

        return Redirect::route('companies.index')->with('success', 'Data Perusahaan Pelaksana berhasil diperbarui!');
    }

    // ... (edit, destroy) TIDAK BERUBAH ...
    
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return Redirect::route('companies.index')->with('success', 'Data Perusahaan Pelaksana berhasil dihapus!');
    }
}