<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Profil Risiko Personel (Individu)') }}
        </h2>
    </x-slot>

    {{-- CSS MODERISASI SELECT2 - WARNA FONT DISAMAKAN --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Samakan warna Border dan Tinggi */
        .select2-container--default .select2-selection--single {
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
            height: 38px !important;
            display: flex;
            align-items: center;
        }

        /* SAMAKAN WARNA FONT PLACEHOLDER (Pilih Personel) */
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #374151 !important; /* Samakan dengan Gray-700 input samping */
            font-size: 0.875rem !important;
        }

        /* SAMAKAN WARNA FONT SAAT SUDAH DIPILIH */
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #374151 !important;
            font-size: 0.875rem !important;
            padding-left: 8px !important;
            font-weight: 500;
        }

        /* Style Dropdown Modern */
        .select2-dropdown {
            border: 1px solid #e5e7eb !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            max-width: 350px !important;
        }

        /* Warna Font di List Pilihan Menurun */
        .select2-container--default .select2-results__option {
            padding: 10px 12px !important;
            font-size: 0.875rem !important;
            color: #374151 !important;
            white-space: normal !important;
            word-break: break-word !important;
        }

        /* Warna saat di-hover (Indigo) */
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #4f46e5 !important;
            color: white !important;
        }

        /* Efek Fokus Outline Indigo */
        .select2-container--focus .select2-selection--single {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2) !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. FORM FILTER --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-6 border-l-4 border-indigo-500">
                <h4 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-tighter">Filter Periode, Perusahaan & Personel</h4>

                <form method="GET" action="{{ route('reports.individu') }}">
                    <div class="flex flex-wrap items-end gap-3">
                        
                        {{-- Tanggal Mulai --}}
                        <div class="flex-1 min-w-[140px]">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ request('start_date', $startDate) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 py-2">
                        </div>

                        {{-- Tanggal Akhir --}}
                        <div class="flex-1 min-w-[140px]">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Tanggal Akhir</label>
                            <input type="date" name="end_date" value="{{ request('end_date', $endDate) }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 py-2">
                        </div>

                        {{-- Perusahaan --}}
                        <div class="flex-1 min-w-[160px]">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Perusahaan Pelaksana</label>
                            <select name="perusahaan" class="w-full border-gray-300 rounded-md shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-700 py-2">
                                <option value="">Semua Perusahaan</option>
                                @foreach($list_perusahaan as $id => $nama)
                                    <option value="{{ $id }}" {{ request('perusahaan') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Nama Personel - WARNA SUDAH DISAMAKAN --}}
                        <div class="flex-1 min-w-[200px] max-w-[250px]">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Nama Personel</label>
                            <select name="nama_personel" class="w-full select2-modern">
                                <option value="">Pilih Personel</option>
                                @foreach($list_personel as $nama)
                                    <option value="{{ $nama }}" {{ (request('nama_personel') == $nama || (isset($namaFilter) && $namaFilter == $nama)) ? 'selected' : '' }}>
                                        {{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex gap-2">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded shadow transition text-sm active:scale-95">
                                Filter
                            </button>
                            
                            <a href="{{ route('reports.cetak', [
                                'jenis' => 'individu', 
                                'start_date' => request('start_date', $startDate), 
                                'end_date' => request('end_date', $endDate), 
                                'perusahaan' => request('perusahaan'),
                                'nama_personel' => request('nama_personel') ?? $namaFilter ?? ''
                            ]) }}" target="_blank" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-5 rounded shadow flex items-center text-sm active:scale-95">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                PDF
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 2. TABEL RIWAYAT --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                        <tr>
                            <th class="px-6 py-4 text-left">Personel & Perusahaan</th>
                            <th class="px-6 py-4 text-center">Total Obs</th>
                            <th class="px-6 py-4 text-center text-red-500">Bahaya</th>
                            <th class="px-6 py-4 text-left italic">Rekomendasi Terakhir</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @forelse($riwayat_individu as $nama => $data)
                        <tr class="hover:bg-gray-50 transition border-b">
                            <td class="px-6 py-4" style="max-width: 300px;">
                                <div class="font-bold text-gray-700 uppercase text-sm leading-tight" style="word-break: break-word;">
                                    {{ $nama }}
                                </div>
                                <div class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest mt-1">
                                    {{ $data['perusahaan_nama'] ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-600">{{ $data['total'] }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 {{ $data['tidak_aman'] > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }} rounded-full font-black text-[10px]">
                                    {{ $data['tidak_aman'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 italic text-xs">{{ $data['rekomendasi_terakhir'] }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Data tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- JS SELECT2 MODERN --}}
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