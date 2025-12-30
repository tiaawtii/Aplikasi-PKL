<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Data Observasi & Temuan Bahaya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Area Filter yang Diperbaiki agar Rapi --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <form method="GET" action="{{ route('reports.rekapitulasi') }}">
                    <div class="flex flex-wrap items-end gap-3">
                        
                        {{-- TANGGAL AWAL --}}
                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" value="{{ $tglAwal }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 py-2">
                        </div>

                        {{-- TANGGAL AKHIR --}}
                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" value="{{ $tglAkhir }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 py-2">
                        </div>

                        {{-- UNIT KERJA --}}
                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Unit Kerja</label>
                            <select name="unit" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 py-2">
                                <option value="">Semua Unit</option>
                                @foreach($list_unit as $id => $nama)
                                    <option value="{{ $id }}" {{ $unit == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- PERUSAHAAN --}}
                        <div class="flex-1 min-w-[180px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Perusahaan Pelaksana</label>
                            <select name="perusahaan" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 py-2">
                                <option value="">Semua Perusahaan</option>
                                @foreach($list_perusahaan as $id => $nama)
                                    <option value="{{ $id }}" {{ (isset($perusahaan) && $perusahaan == $id) ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- STATUS AMAN --}}
                        <div class="flex-1 min-w-[140px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status Aman?</label>
                            <select name="status_aman" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 py-2">
                                <option value="">Semua Status</option>
                                <option value="Ya" {{ $statusAman == 'Ya' ? 'selected' : '' }}>Ya (Aman)</option>
                                <option value="Tidak" {{ $statusAman == 'Tidak' ? 'selected' : '' }}>Tidak (Bahaya)</option>
                            </select>
                        </div>
                        
                        {{-- Grup Tombol --}}
                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 font-bold transition shadow-sm text-sm">
                                Filter
                            </button>
                            {{-- Tombol Cetak PDF dengan Icon --}}
                            <a href="{{ route('reports.cetak', [
                                'jenis' => 'rekapitulasi', 
                                'tgl_awal' => $tglAwal, 
                                'tgl_akhir' => $tglAkhir, 
                                'unit' => $unit, 
                                'status_aman' => $statusAman,
                                'perusahaan' => $perusahaan ?? ''
                            ]) }}" target="_blank" class="bg-red-600 text-white px-5 py-2 rounded-md hover:bg-red-700 font-bold transition shadow-sm text-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Cetak PDF
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Tabel Laporan --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Data Pekerjaan</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Temuan Bahaya & Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @forelse($semua_observasi as $obs)
                        <tr>
                            <td class="px-6 py-4">
                                {{-- Menampilkan Unit Kerja --}}
                                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">
                                    Unit: {{ $obs->workUnit->nama_unit ?? 'N/A' }}
                                </div>
                                
                                <div class="font-bold text-indigo-700 uppercase text-base">
                                    {{ $obs->company->nama ?? 'N/A' }}
                                </div>
                                
                                <div class="text-xs text-gray-600 mt-1 font-medium">
                                    {{ $obs->lokasi_pekerjaan }} | {{ \Carbon\Carbon::parse($obs->tanggal)->format('d-m-Y') }}
                                </div>
                                
                                <div class="text-xs text-gray-400 mt-1 italic">
                                    Pekerjaan: {{ $obs->jenis_pekerjaan }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($obs->dokumen_dilaksanakan_baik == 'Ya')
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-[10px] font-bold uppercase tracking-wider">AMAN</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-[10px] font-bold uppercase tracking-wider">BAHAYA</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                @if($obs->dokumen_dilaksanakan_baik == 'Tidak')
                                    <div class="text-red-600 font-semibold">Temuan: {{ $obs->unsafe_actions_conditions ?? '-' }}</div>
                                    <div class="text-green-700 text-xs italic mt-1">Saran: {{ $obs->rekomendasi_perbaikan ?? '-' }}</div>
                                @else
                                    <span class="text-gray-400 italic">Tidak ada temuan bahaya</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">
                                Data tidak ditemukan untuk periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>