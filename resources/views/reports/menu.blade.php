<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Menu Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Pilih Jenis Laporan</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    </p>

                    {{-- Grid untuk 5 kotak menu --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- 1. Rekapitulasi JSO -->
                        <a href="{{ route('laporan.rekapitulasiJso') }}" class="block p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border-l-4 border-yellow-400 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center">
                                <h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">Rekapitulasi JSO</h5>
                            </div>
                            <p class="font-normal text-gray-600 dark:text-gray-400 text-sm mt-1">Menampilkan rekapitulasi Job Safety Observation.</p>
                        </a>

                        <!-- 2. Laporan Bahaya -->
                        <a href="{{ route('laporan.bahaya') }}" class="block p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border-l-4 border-yellow-400 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center">
                                <h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">Laporan Bahaya</h5>
                            </div>
                            <p class="font-normal text-gray-600 dark:text-gray-400 text-sm mt-1">Data dari isian "Unsafe Actions/Conditions".</p>
                        </a>

                        <!-- 3. Kinerja Vendor -->
                        <a href="{{ route('laporan.kinerjaVendor') }}" class="block p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border-l-4 border-yellow-400 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center">
                                <h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">Kinerja Vendor</h5>
                            </div>
                            <p class="font-normal text-gray-600 dark:text-gray-400 text-sm mt-1">Data dari isian "Perusahaan Pelaksana".</p>
                        </a>

                        <!-- 4. Kelengkapan Dokumen -->
                        <a href="{{ route('laporan.kelengkapanDokumen') }}" class="block p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border-l-4 border-yellow-400 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center">
                                <h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">Kelengkapan Dokumen</h5>
                            </div>
                            <p class="font-normal text-gray-600 dark:text-gray-400 text-sm mt-1">Data dari checklist dokumen (SOP, JSA, dll).</p>
                        </a>

                        <!-- 5. Riwayat Observasi Individu -->
                        <a href="{{ route('laporan.riwayatIndividu') }}" class="block p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border-l-4 border-yellow-400 hover:shadow-md transition-all duration-300">
                            <div class="flex items-center">
                                <h5 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">Riwayat Observasi Individu</h5>
                            </div>
                            <p class="font-normal text-gray-600 dark:text-gray-400 text-sm mt-1">Daftar nama pekerja dan skor keselamatannya (total observasi vs. temuan unsafe).</p>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>