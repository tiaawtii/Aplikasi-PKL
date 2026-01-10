<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pegawai K3LK') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-700">Daftar Pegawai K3LK</h3>
                    
                    {{-- TOMBOL TAMBAH HANYA UNTUK ADMIN --}}
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('k3lk_employees.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg">
                            Tambah Pegawai Baru
                        </a>
                    @endif
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto border rounded-lg shadow-sm">
                    <table class="min-w-full table-auto divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIP</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pegawai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                                
                                {{-- KOLOM AKSI HANYA UNTUK ADMIN --}}
                                @if(Auth::user()->role === 'admin')
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pegawai as $p)
                                <tr class="hover:bg-gray-50" x-data="{ openDelete: false }">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p->nip }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p->nama_pegawai }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p->jabatan }}</td>
                                    
                                    {{-- ISI AKSI HANYA UNTUK ADMIN --}}
                                    @if(Auth::user()->role === 'admin')
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2">
                                                <a href="{{ route('k3lk_employees.edit', $p->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                                <span class="text-gray-300">|</span>
                                                <button type="button" @click="openDelete = true" class="text-red-600 hover:text-red-900">
                                                    Hapus
                                                </button>
                                            </div>

                                            <template x-teleport="body">
                                                <div x-show="openDelete" 
                                                     class="fixed inset-0 z-[100] flex justify-center items-start pt-16 overflow-y-auto" 
                                                     style="display: none;" 
                                                     x-cloak>
                                                    
                                                    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" @click="openDelete = false"></div>

                                                    <div class="relative bg-white rounded-lg max-w-lg w-full p-8 shadow-2xl transform transition-all mx-4"
                                                         x-show="openDelete"
                                                         x-transition:enter="transition ease-out duration-300"
                                                         x-transition:enter-start="opacity-0 -translate-y-12"
                                                         x-transition:enter-end="opacity-100 translate-y-0">
                                                        
                                                        <div class="text-left">
                                                            <h3 class="text-xl leading-6 font-bold text-gray-900 mb-4">Konfirmasi Penghapusan</h3>
                                                            <p class="text-sm text-gray-600">
                                                                Apakah Anda yakin ingin menghapus data pegawai <strong>{{ $p->nama_pegawai }}</strong>?
                                                            </p>
                                                            <p class="text-xs text-red-600 mt-2 font-semibold">Data yang sudah dihapus tidak dapat dikembalikan.</p>
                                                        </div>

                                                        <div class="mt-8 flex justify-end space-x-3">
                                                            <button type="button" @click="openDelete = false" 
                                                                    class="px-8 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-md hover:bg-gray-50 transition-colors">
                                                                BATAL
                                                            </button>
                                                            <form action="{{ route('k3lk_employees.destroy', $p->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="px-6 py-2 bg-red-600 text-white text-sm font-bold rounded-md hover:bg-red-700 shadow-md">
                                                                    YA, HAPUS DATA
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role === 'admin' ? 5 : 4 }}" class="px-6 py-4 text-center text-sm text-gray-500 italic">Belum ada data pegawai.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>