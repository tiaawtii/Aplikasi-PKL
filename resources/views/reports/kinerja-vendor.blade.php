<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Kinerja Keselamatan Vendor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. FORM FILTER dan CETAK PDF --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-l-4 border-yellow-500">
                <h4 class="text-lg font-bold text-gray-800 mb-4">Filter Data Perusahaan Pelaksana</h4>

                <form method="GET" action="{{ route('reports.vendor') }}">
                    {{-- Container Flex supaya rapi tanpa unit kerja --}}
                    <div class="flex flex-wrap items-end gap-3">

                        {{-- TANGGAL AWAL --}}
                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" value="{{ request('tgl_awal', $tglAwal ?? '') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-yellow-500 focus:border-yellow-500 text-gray-700 py-2">
                        </div>

                        {{-- TANGGAL AKHIR --}}
                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" value="{{ request('tgl_akhir', $tglAkhir ?? '') }}"
                                class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-yellow-500 focus:border-yellow-500 text-gray-700 py-2">
                        </div>

                        {{-- PERUSAHAAN --}}
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Perusahaan Pelaksana</label>
                            <select name="perusahaan" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-yellow-500 focus:border-yellow-500 text-gray-700 py-2">
                                <option value="">Semua Perusahaan</option>
                                @foreach($list_perusahaan as $id => $nama)
                                    <option value="{{ $id }}" {{ request('perusahaan') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- TOMBOL FILTER & CETAK --}}
                        <div class="flex gap-2">
                            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-5 rounded shadow transition text-sm">
                                Filter
                            </button>
                            
                            {{-- Tombol Cetak PDF dengan Icon Printer --}}
                            <a href="{{ route('reports.cetak', [
                                'jenis' => 'vendor', 
                                'tgl_awal' => request('tgl_awal', $tglAwal ?? ''), 
                                'tgl_akhir' => request('tgl_akhir', $tglAkhir ?? ''), 
                                'perusahaan' => request('perusahaan')
                            ]) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-5 rounded shadow transition flex items-center text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Cetak PDF
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 2. TABEL KINERJA --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Perusahaan</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Total Obs</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider text-green-600">Aman</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider text-red-600">Bahaya</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Tingkat Kepatuhan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($kinerja_perusahaan as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 uppercase">
                                {{ $item['nama'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                {{ $item['total'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-green-600">
                                {{ $item['aman'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-red-600">
                                {{ $item['tidak_aman'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm font-black {{ $item['persentase_aman'] >= 80 ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $item['persentase_aman'] }}%
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">Data vendor tidak ditemukan untuk periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>