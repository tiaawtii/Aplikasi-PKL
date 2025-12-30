<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Temuan Bahaya (Unsafe Conditions/Actions)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- 1. FORM FILTER dan CETAK PDF (Ringkas) --}}
            <div class="bg-white p-6 rounded-lg shadow-xl mb-8">
                <h4 class="text-xl font-bold text-gray-800 mb-4">Filter Data Laporan</h4>
                
                <form method="GET" action="{{ route('laporan.bahaya') }}">
                    {{-- Grid 5 kolom untuk 4 filter input + 1 kolom untuk tombol aksi --}}
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 items-end"> 
                        
                        {{-- Filter 1: Tanggal Observasi TUNGGAL --}}
                        <div class="col-span-1">
                            <label for="tanggal_tunggal" class="block text-sm font-medium text-gray-700">Tanggal Observasi</label>
                            <input type="date" name="tanggal_tunggal" id="tanggal_tunggal" 
                                value="{{ request('tanggal_tunggal') }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        </div>
                        
                        {{-- Filter 2: Lokasi --}}
                        <div class="col-span-1">
                            <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                            <select name="lokasi" id="lokasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Semua</option>
                                {{-- Ganti dengan data unik dari Controller jika tersedia --}}
                                {{-- @if (isset($list_lokasi))
                                    @foreach($list_lokasi as $lokasi)
                                        <option value="{{ $lokasi }}" @if(request('lokasi') == $lokasi) selected @endif>{{ $lokasi }}</option>
                                    @endforeach
                                @endif --}}
                            </select>
                        </div>

                        {{-- Filter 3: Pelaksana --}}
                        <div class="col-span-1">
                            <label for="pelaksana" class="block text-sm font-medium text-gray-700">Pelaksana</label>
                            <select name="pelaksana" id="pelaksana" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Semua</option>
                                {{-- Ganti dengan data unik dari Controller jika tersedia --}}
                                {{-- @if (isset($list_pelaksana))
                                    @foreach($list_pelaksana as $pelaksana)
                                        <option value="{{ $pelaksana }}" @if(request('pelaksana') == $pelaksana) selected @endif>{{ $pelaksana }}</option>
                                    @endforeach
                                @endif --}}
                            </select>
                        </div>
                        
                        {{-- Filter 4: Status Aman (Hanya Tampilkan Tidak Aman, Input Disembunyikan) --}}
                        <div class="col-span-1">
                            <label for="status_aman" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status_aman" id="status_aman" disabled class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-red-700 bg-gray-50 text-sm">
                                <option value="Tidak" selected>Tidak Aman</option>
                            </select>
                            <input type="hidden" name="status_aman" value="Tidak">
                        </div>
                        
                        {{-- Tombol Aksi --}}
                        <div class="col-span-2 md:col-span-1 flex justify-end items-end space-x-2">
                            <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 h-10 flex-grow">
                                Tampilkan
                            </button>
                            
                            {{-- Tombol Cetak PDF --}}
                            <a href="{{ route('laporan.cetak', array_merge(request()->query(), ['jenis' => 'bahaya'])) }}" 
                               target="_blank"
                               class="inline-flex justify-center items-center px-2 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 h-10 w-10">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m0 0v2a2 2 0 002 2h6a2 2 0 002-2v-2m0 0H7m7 0h-4"></path></svg>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            
            {{-- Bagian Tabel Detail --}}
            @forelse($temuan_bahaya as $temuan) @empty
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md shadow-md" role="alert">
                    <p class="font-bold">Informasi</p>
                    <p>Tidak ada temuan bahaya yang ditemukan untuk periode filter ini.</p>
                </div>
            @endforelse

            @if ($temuan_bahaya->isNotEmpty())
                {{-- TIDAK ADA KARTU STATISTIK DI SINI --}}

                {{-- Detail Tabel Modern --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-gray-800 mb-4">Detail Temuan Bahaya (Total: {{ $temuan_bahaya->count() }})</h4>
                        <div class="overflow-x-auto border rounded-lg shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelaksana</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan Unsafe / Kondisi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($temuan_bahaya as $temuan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $temuan->tanggal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $temuan->lokasi_pekerjaan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $temuan->perusahaan_pelaksana }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $temuan->nama_observer }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">{{ $temuan->unsafe_actions_conditions }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>