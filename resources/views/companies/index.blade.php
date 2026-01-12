<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Perusahaan Pelaksana') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- HEADER & TOMBOL --}}
                    <div class="flex justify-between items-center mb-4 border-b border-gray-100 dark:border-gray-700 pb-4">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            Daftar Perusahaan Pelaksana
                        </h3>
                        
                        {{-- TOMBOL TAMBAH HANYA UNTUK ADMIN --}}
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('companies.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150 ease-in-out">
                                Tambah Perusahaan Baru
                            </a>
                        @endif
                    </div>
                    
                    {{-- Tabel Data Perusahaan --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        KODE
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nama Perusahaan
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Kontak
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Email
                                    </th>
                                    
                                    {{-- HEADER AKSI HANYA UNTUK ADMIN --}}
                                    @if(Auth::user()->role === 'admin')
                                        <th class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            AKSI
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @forelse ($companies as $company)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600 dark:text-indigo-400 text-center">
                                            {{ $company->kode_perusahaan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-left">
                                            <p class="font-bold">{{ $company->nama }}</p>
                                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ Str::limit($company->alamat, 50) ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">{{ $company->kontak ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">{{ $company->email ?? '-' }}</td>
                                        
                                        {{-- KOLOM AKSI HANYA UNTUK ADMIN --}}
                                        @if(Auth::user()->role === 'admin')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                                <div class="inline-flex items-center m-0 p-0">
                                                    <a href="{{ route('companies.edit', $company) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 mr-2">Edit</a>
                                                    
                                                    <span class="text-gray-400 dark:text-gray-500 mr-2">|</span> 

                                                    <button type="button" 
                                                        x-data=""
                                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-company-deletion-{{ $company->id }}')" 
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600 font-normal">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ Auth::user()->role === 'admin' ? 5 : 4 }}" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada data perusahaan pelaksana.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- MODAL HAPUS HANYA DI-RENDER UNTUK ADMIN --}}
@if(Auth::user()->role === 'admin')
    @foreach ($companies as $company)
        <x-modal name="confirm-company-deletion-{{ $company->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('companies.destroy', $company) }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Konfirmasi Penghapusan') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Apakah Anda yakin ingin menghapus data perusahaan') }} 
                    <span class="font-bold text-indigo-500">{{ $company->nama }}</span> ({{ $company->kode_perusahaan }})?
                </p>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Batal') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Ya, Hapus Data') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    @endforeach
@endif

</x-app-layout>