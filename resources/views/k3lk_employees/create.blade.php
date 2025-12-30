<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Pegawai K3LK Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-700">Formulir Data Pegawai</h3>
                    <p class="text-sm text-gray-500">Pastikan NIP yang dimasukkan benar dan unik.</p>
                </div>

                <form action="{{ route('k3lk_employees.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: 12345678" required>
                        @error('nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nama_pegawai" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_pegawai" id="nama_pegawai" value="{{ old('nama_pegawai') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="mb-6">
                        <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <select name="jabatan" id="jabatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Team Leader K3LK">Team Leader K3LK</option>
                            <option value="Pengawas K3LK">Pengawas K3LK</option>
                            <option value="Staff K3LK">Staff K3LK</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t pt-4">
                        <a href="{{ route('k3lk_employees.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-md">
                            Simpan Data Pegawai
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>