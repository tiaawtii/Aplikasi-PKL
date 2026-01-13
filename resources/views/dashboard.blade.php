<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Job Safety Observation') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Card Selamat Datang Slim & Rapi --}}
            <div class="mb-6 p-5 bg-white rounded-xl shadow-md border-l-4 border-indigo-500">
                <h3 class="text-xl font-bold text-gray-900">Selamat Datang, {{ Auth::user()->name ?? 'User' }}!</h3>
                <p class="text-sm text-gray-600">Total seluruh data observasi: <span class="font-bold text-indigo-600">{{ $totalAll ?? 0 }}</span>.</p>
            </div>

            <div class="space-y-6">
                
                {{-- 1. Statistik Utama --}}
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-blue-500 transition-all hover:shadow-lg">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Observasi</p>
                        <p class="text-3xl font-black text-blue-900 mt-1">{{ $totalObsThisMonth ?? 0 }}</p>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-emerald-500 transition-all hover:shadow-lg">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kepatuhan</p>
                        <p class="text-3xl font-black text-emerald-600 mt-1">{{ $complianceRate ?? 0 }}%</p>
                    </div>

                    <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-rose-500 transition-all hover:shadow-lg">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Temuan Bahaya</p>
                        <p class="text-3xl font-black text-rose-600 mt-1">{{ $tidakAmanObs ?? 0 }}</p>
                    </div>
                    
                    <div class="bg-white p-5 rounded-xl shadow-md border-b-4 border-amber-500 transition-all hover:shadow-lg">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Review Selesai</p>
                        <p class="text-3xl font-black text-amber-600 mt-1">{{ $reviewCompletionRate ?? 0 }}%</p>
                    </div>
                </div>

                {{-- 2. Area Grafik & Aksi Cepat Berdampingan --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    
                    {{-- Chart 1: Status (Doughnut) --}}
                    <div class="lg:col-span-4 bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <h4 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-tighter">Status Kondisi Lapangan</h4>
                        <div class="relative h-56">
                            <canvas id="complianceChart"></canvas> 
                        </div>
                    </div>

                    {{-- Chart 2: Tren Bulanan (Bar Chart) --}}
                    <div class="lg:col-span-5 bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <h4 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-tighter">Grafik Tren Bulanan</h4>
                        <div class="relative h-56">
                            <canvas id="trendChart"></canvas> 
                        </div>
                    </div>

                    {{-- 3. Card Aksi Cepat --}}
                    <div class="lg:col-span-3 bg-white p-6 rounded-xl shadow-md border border-gray-100">
                        <h4 class="text-sm font-bold text-gray-700 mb-4 uppercase tracking-tighter ml-1">Aksi Cepat</h4>
                        <div class="space-y-4">
                            <a href="{{ route('observations.create') }}" class="group flex items-center p-4 bg-indigo-600 rounded-xl shadow-lg hover:bg-indigo-700 transition-all active:scale-95 text-white">
                                <div class="bg-white/20 p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <span class="font-bold text-sm uppercase">Input JSO</span>
                            </a>
                            
                            <a href="{{ route('reports.index') }}" class="group flex items-center p-4 bg-slate-700 rounded-xl shadow-lg hover:bg-slate-800 transition-all active:scale-95 text-white">
                                <div class="bg-white/20 p-2 rounded-lg mr-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <span class="font-bold text-sm uppercase">Laporan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Doughnut Chart
            const ctx1 = document.getElementById('complianceChart');
            new Chart(ctx1, {
                type: 'doughnut', 
                data: {
                    labels: ['Aman', 'Bahaya'],
                    datasets: [{
                        data: [{{ $amanObs ?? 0 }}, {{ $tidakAmanObs ?? 0 }}],
                        backgroundColor: ['#10b981', '#f43f5e'],
                        borderWidth: 0,
                        cutout: '70%'
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { 
                        legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10, weight: 'bold' } } } 
                    }
                }
            });

            // 2. Bar Chart (Perbaikan Nama Bulan Indonesia)
            const monthMap = {
                'January': 'Januari', 'February': 'Februari', 'March': 'Maret',
                'April': 'April', 'May': 'Mei', 'June': 'Juni',
                'July': 'Juli', 'August': 'Agustus', 'September': 'September',
                'October': 'Oktober', 'November': 'November', 'December': 'Desember'
            };

            const rawLabels = {!! json_encode($labelsTrend) !!};
            const translatedLabels = rawLabels.map(label => {
                // Mencocokkan nama bulan Inggris di dalam string label
                for (const [eng, ind] of Object.entries(monthMap)) {
                    if (label.includes(eng)) {
                        return label.replace(eng, ind);
                    }
                }
                return label;
            });

            const ctx2 = document.getElementById('trendChart');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: translatedLabels,
                    datasets: [{
                        label: 'Observasi',
                        data: {!! json_encode($dataTrend) !!},
                        backgroundColor: '#6366f1',
                        borderRadius: 6,
                        barThickness: 25,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { 
                        y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10, weight: 'bold' } } },
                        x: { grid: { display: false }, ticks: { font: { size: 10, weight: 'bold' } } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</x-app-layout>