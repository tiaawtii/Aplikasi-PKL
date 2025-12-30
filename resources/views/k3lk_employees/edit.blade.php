<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Pegawai K3LK') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-700">Formulir Edit Data Pegawai</h3>
                    <p class="text-sm text-gray-500">Perbarui informasi pegawai sesuai dengan data terbaru.</p>
                </div>

                <form action="{{ route('k3lk_employees.update', $k3lk_employee->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <label for="nip" class="block text-sm font-medium text-gray-700">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip', $k3lk_employee->nip) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: 12345678" required>
                        @error('nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="nama_pegawai" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_pegawai" id="nama_pegawai" value="{{ old('nama_pegawai', $k3lk_employee->nama_pegawai) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan nama lengkap" required>
                        @error('nama_pegawai') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <select name="jabatan" id="jabatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="Team Leader K3LK" {{ old('jabatan', $k3lk_employee->jabatan) == 'Team Leader K3LK' ? 'selected' : '' }}>Team Leader K3</option>
                            <option value="Pengawas K3LK" {{ old('jabatan', $k3lk_employee->jabatan) == 'Pengawas K3LK' ? 'selected' : '' }}>Pengawas K3</option>
                            <option value="Staff K3LK" {{ old('jabatan', $k3lk_employee->jabatan) == 'Staff K3LK' ? 'selected' : '' }}>Staff K3</option>
                        </select>
                        @error('jabatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t pt-4">
                        <a href="{{ route('k3lk_employees.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-md">
                            Perbarui Data Pegawai
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>