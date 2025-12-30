<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Input Perusahaan Pelaksana Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Form Input Data Perusahaan --}}
                    <form method="POST" action="{{ route('companies.store') }}">
                        @csrf
                        
                        <div class="space-y-4">
                            
                            {{-- Nama Perusahaan (Wajib) --}}
                            <div>
                                <x-input-label for="nama" :value="__('Nama Perusahaan')" />
                                <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                            </div>

                            {{-- Alamat --}}
                            <div>
                                <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                                <textarea id="alamat" name="alamat" rows="3" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ old('alamat') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                            </div>

                            {{-- Kontak --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="kontak" :value="__('Nomor Kontak / PIC')" />
                                    <x-text-input id="kontak" class="block mt-1 w-full" type="text" name="kontak" :value="old('kontak')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('kontak')" />
                                </div>

                                {{-- Email --}}
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('companies.index') }}" class="mr-4 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Perusahaan') }}
                            </x-primary-button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>