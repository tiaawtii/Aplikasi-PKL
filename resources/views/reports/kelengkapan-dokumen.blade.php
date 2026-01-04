<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Kelengkapan Dokumen') }}
        </h2>
    </x-slot>

    {{-- CSS MODERN SELECT2 UNTUK DROPDOWN NAMA --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
            height: 38px !important;
            display: flex;
            align-items: center;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder,
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #374151 !important;
            font-size: 0.875rem !important;
        }
        .select2-dropdown {
            border: 1px solid #e5e7eb !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            max-width: 350px !important;
        }
        .select2-container--default .select2-results__option {
            padding: 10px 12px !important;
            font-size: 0.875rem !important;
            color: #374151 !important;
            white-space: normal !important;
            word-break: break-word !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. FORM FILTER dan CETAK PDF --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-l-4 border-green-500">
                <h4 class="text-lg font-bold text-gray-800 mb-4">Filter Kepatuhan Dokumen</h4>

                <form method="GET" action="{{ route('reports.dokumen') }}">
                    <div class="flex flex-wrap items-end gap-3">
                        
                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal Awal</label>
                            <input type="date" name="tgl_awal" value="{{ request('tgl_awal', $tglAwal ?? '') }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 text-gray-700 py-2">
                        </div>

                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tanggal Akhir</label>
                            <input type="date" name="tgl_akhir" value="{{ request('tgl_akhir', $tglAkhir ?? '') }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 text-gray-700 py-2">
                        </div>

                        <div class="flex-1 min-w-[180px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Perusahaan Pelaksana</label>
                            <select name="perusahaan" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 text-gray-700 py-2">
                                <option value="">Semua Perusahaan</option>
                                @foreach($list_perusahaan as $id => $nama)
                                    <option value="{{ $id }}" {{ request('perusahaan') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-1 min-w-[200px] max-w-[250px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Personel</label>
                            <select name="nama_personel" class="w-full select2-modern">
                                <option value="">Semua Personel</option>
                                @foreach($list_personel as $nama)
                                    <option value="{{ $nama }}" {{ request('nama_personel') == $nama ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex-1 min-w-[150px]">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status Dokumen</label>
                            <select name="filter_dokumen" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500 text-gray-700 py-2">
                                <option value="">Semua</option>
                                <option value="Lengkap" {{ request('filter_dokumen') == 'Lengkap' ? 'selected' : '' }}>Lengkap</option>
                                <option value="Tidak Lengkap" {{ request('filter_dokumen') == 'Tidak Lengkap' ? 'selected' : '' }}>Tidak Lengkap</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-5 rounded shadow transition text-sm active:scale-95">
                                Filter
                            </button>
                            <a href="{{ route('reports.cetak', [
                                'jenis' => 'dokumen', 
                                'tgl_awal' => request('tgl_awal', $tglAwal ?? ''), 
                                'tgl_akhir' => request('tgl_akhir', $tglAkhir ?? ''), 
                                'filter_dokumen' => request('filter_dokumen'),
                                'perusahaan' => request('perusahaan'),
                                'nama_personel' => request('nama_personel')
                            ]) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-5 rounded shadow transition flex items-center text-sm active:scale-95">
                                Cetak PDF
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 2. TABEL AUDIT DOKUMEN --}}
            <div class="bg-white overflow-x-auto shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-center text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">Pelaksana & Nama Personel</th>
                            <th class="px-2 py-3">No. WP</th>
                            <th class="px-2 py-3">WP</th>
                            <th class="px-2 py-3">SOP</th>
                            <th class="px-2 py-3">JSA</th>
                            <th class="px-2 py-3">IK</th>
                            <th class="px-2 py-3">IBPPR</th>
                            <th class="px-6 py-3 text-right">Lampiran Bukti</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-center text-sm">
                        @forelse($semua_observasi as $obs)
                            @php $docs = json_decode($obs->dokumen_tersedia, true) ?? []; @endphp
                        <tr class="hover:bg-gray-50 transition border-b">
                            <td class="px-6 py-4 text-left">
                                <div class="font-bold text-indigo-700 uppercase text-xs">{{ $obs->company->nama ?? 'N/A' }}</div>
                                <div class="text-gray-900 font-semibold mt-1" style="word-break: break-word; max-width: 300px;">
                                    Personel: {{ $obs->nama_personel_diobservasi }}
                                </div>
                                <div class="text-[10px] text-gray-400 italic mt-1">Tanggal: {{ \Carbon\Carbon::parse($obs->tanggal)->format('d-m-Y') }}</div>
                            </td>
                            
                            <td class="px-2 py-4">
                                <span class="text-[11px] font-bold text-green-700">{{ $obs->no_wp ?? '-' }}</span>
                            </td>

                            @foreach(['WP', 'SOP', 'JSA', 'IK', 'IBPPR'] as $doc)
                            <td class="px-2 py-4">
                                @if(in_array($doc, $docs))
                                    <span class="text-green-600 font-bold">✔</span>
                                @else
                                    <span class="text-red-400 font-bold">✘</span>
                                @endif
                            </td>
                            @endforeach

                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                @if($obs->bukti_dokumen_path)
                                    @php 
                                        $extension = pathinfo($obs->bukti_dokumen_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                                    @endphp

                                    <a href="{{ asset('storage/' . $obs->bukti_dokumen_path) }}" target="_blank" 
                                       class="inline-flex items-center text-indigo-600 hover:text-indigo-900 text-[10px] font-bold border border-indigo-200 px-3 py-1.5 rounded-lg bg-indigo-50 transition">
                                       @if($isImage)
                                          Lihat Foto
                                       @else
                                          Lihat Dokumen
                                       @endif
                                    </a>
                                @else
                                    <span class="text-gray-400 text-[10px] italic bg-gray-100 px-2 py-1 rounded">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-400 italic">Data dokumen tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- JS UNTUK SELECT2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-modern').select2({
                placeholder: "Pilih Personel",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
</x-app-layout>