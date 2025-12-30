<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu Laporan JSO') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- 1. Ringkasan Eksekutif & Statistik Bahaya --}}
                <a href="{{ route('reports.rekapitulasi') }}" class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500 hover:bg-blue-50 transition duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg text-blue-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Ringkasan & Bahaya</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Gabungan total observasi, status aman, dan detail temuan Unsafe Action/Condition.</p>
                </a>

                {{-- 2. Kinerja Vendor --}}
                <a href="{{ route('reports.vendor') }}" class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500 hover:bg-yellow-50 transition duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-yellow-100 rounded-lg text-yellow-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Kinerja Vendor</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Analisis performa keselamatan dan tingkat kepatuhan per Perusahaan Pelaksana.</p>
                </a>

                {{-- 3. Riwayat Individu --}}
                <a href="{{ route('reports.individu') }}" class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-indigo-500 hover:bg-indigo-50 transition duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Profil Risiko Personel</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Rekam jejak observasi untuk setiap personel yang diobservasi secara individu.</p>
                </a>

                {{-- 4. Kepatuhan Dokumen --}}
                <a href="{{ route('reports.dokumen') }}" class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500 hover:bg-green-50 transition duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-green-100 rounded-lg text-green-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Kelengkapan Dokumen</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Analisis kepatuhan checklist dokumen (SOP, JSA, IK, dll) di lokasi kerja.</p>
                </a>

                {{-- 5. Verifikasi Evidence (Laporan BARU) --}}
                <a href="{{ route('reports.evidence') }}" class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-purple-500 hover:bg-purple-50 transition duration-300 md:col-span-2 lg:col-span-1">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-purple-100 rounded-lg text-purple-600 mr-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Verifikasi Evidence</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Validasi verifikasi data melalui foto bukti dokumen dan bukti review lapangan.</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>