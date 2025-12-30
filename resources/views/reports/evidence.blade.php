<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Verifikasi Evidence & Foto Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Filter Area: Menggunakan Range Tanggal Awal & Akhir agar tidak error --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-l-4 border-purple-500">
                <form method="GET" action="{{ route('reports.evidence') }}" class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                    
                    {{-- Filter Tanggal Awal --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" value="{{ $tglAwal }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-purple-500 focus:border-purple-500 text-gray-700">
                    </div>

                    {{-- Filter Tanggal Akhir --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" value="{{ $tglAkhir }}" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-purple-500 focus:border-purple-500 text-gray-700">
                    </div>

                    {{-- FILTER: Perusahaan Pelaksana --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Perusahaan</label>
                        <select name="perusahaan" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-purple-500 focus:border-purple-500 text-gray-700">
                            <option value="">Semua Perusahaan</option>
                            @foreach($list_perusahaan as $id => $nama)
                                <option value="{{ $id }}" {{ (isset($perusahaan) && $perusahaan == $id) ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- FILTER: Cari Nama Pekerjaan --}}
                    <div>
                        <label class="block text-[10px] font-bold text-gray-700 uppercase mb-1">Cari Pekerjaan</label>
                        <input type="text" name="cari_pekerjaan" value="{{ $cariPekerjaan ?? '' }}" placeholder="Ketik nama..." class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-purple-500 focus:border-purple-500 text-gray-700">
                    </div>

                    {{-- TOMBOL FILTER & CETAK --}}
                    <div class="md:col-span-2 flex gap-2">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition font-bold shadow-sm text-sm">
                            Filter
                        </button>
                        <a href="{{ route('reports.cetak', [
                            'jenis' => 'evidence', 
                            'tgl_awal' => $tglAwal, 
                            'tgl_akhir' => $tglAkhir, 
                            'perusahaan' => $perusahaan ?? '',
                            'cari_pekerjaan' => $cariPekerjaan ?? ''
                        ]) }}" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition flex items-center font-bold shadow-sm text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Cetak PDF
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tabel Evidence --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">Pelaksana / Pekerjaan</th>
                            <th class="px-4 py-3">Foto Bukti Dokumen</th>
                            <th class="px-4 py-3">Foto Bukti Review</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center text-sm">
                        @forelse($semua_observasi as $obs)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-left">
                                <div class="font-bold text-indigo-700 uppercase">{{ $obs->company->nama ?? 'N/A' }}</div>
                                <div class="text-xs text-blue-600 font-semibold mt-1">Pekerjaan: {{ $obs->jenis_pekerjaan ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">Observer: {{ $obs->observer->nama_pegawai ?? 'N/A' }}</div>
                                <div class="text-[10px] text-gray-400 italic">Tanggal: {{ \Carbon\Carbon::parse($obs->tanggal)->format('d-m-Y') }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-center">
                                    @if($obs->bukti_dokumen_path)
                                        <a href="{{ asset('storage/' . $obs->bukti_dokumen_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $obs->bukti_dokumen_path) }}" class="h-16 w-24 object-cover rounded shadow-sm border hover:scale-110 transition-transform">
                                        </a>
                                    @else
                                        <span class="text-red-400 text-[10px] italic">Tidak Ada Foto</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-center">
                                    @if($obs->foto_review_path)
                                        <a href="{{ asset('storage/' . $obs->foto_review_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $obs->foto_review_path) }}" class="h-16 w-24 object-cover rounded shadow-sm border hover:scale-110 transition-transform">
                                        </a>
                                    @else
                                        <span class="text-red-400 text-[10px] italic font-semibold">Tidak Ada Foto</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                @if($obs->bukti_dokumen_path && $obs->foto_review_path)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-[10px] font-bold uppercase border border-green-200">Lengkap</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-[10px] font-bold uppercase border border-yellow-200">Parsial</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-10 text-gray-400 italic text-center">Data tidak ditemukan untuk periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>