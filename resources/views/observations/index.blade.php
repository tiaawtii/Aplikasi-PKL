<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Observasi K3') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-md" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-700">Daftar Observasi</h3>
                        <a href="{{ route('observations.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 transition ease-in-out duration-150 shadow-lg">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Observasi Baru
                        </a>
                    </div>

                    <div class="overflow-x-auto border rounded-lg shadow-sm">
                        <table class="min-w-full table-auto divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pekerjaan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelaksana</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observer</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aman</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($observations as $observasi)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $loop->iteration }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{-- PERBAIKAN: Menghilangkan 00:00:00 dengan format Carbon --}}
                                            {{ \Carbon\Carbon::parse($observasi->tanggal)->format('d-m-Y') }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $observasi->jenis_pekerjaan }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $observasi->lokasi_pekerjaan }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $observasi->company->nama ?? 'N/A' }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $observasi->observer->nama_pegawai ?? 'N/A' }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            @if($observasi->dokumen_dilaksanakan_baik == 'Ya')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Ya</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tidak</span>
                                            @endif
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2">
                                                <a href="{{ route('observations.edit', $observasi->id) }}" 
                                                    class="text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out font-semibold">
                                                    Edit
                                                </a>

                                                <span class="text-gray-400">|</span> 

                                                <button type="button"
                                                    x-data="{}" 
                                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $observasi->id }}')"
                                                    class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out font-semibold">
                                                    Hapus
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500 italic">
                                            Belum ada data observasi.
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

    @foreach ($observations as $observasi)
    <x-modal name="confirm-deletion-{{ $observasi->id }}" focusable>
        <form method="post" action="{{ route('observations.destroy', $observasi->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-extrabold text-red-700">
                {{ __('Hapus Data Observasi') }}
            </h2>

            <p class="mt-4 text-gray-700">
                Apakah Anda yakin ingin menghapus data observasi No. {{ $loop->iteration }} ini? 
                <span class="block mt-1 font-semibold">Tindakan ini tidak dapat dibatalkan.</span>
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="font-semibold">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="font-semibold">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.99-1.858L5 7m14 0H5m14 0V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 0h-4"></path></svg>
                    {{ __('Hapus Permanen') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    @endforeach

</x-app-layout>