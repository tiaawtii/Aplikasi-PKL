<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use App\Models\Company; 
use App\Models\WorkUnit; 
use App\Models\K3lkEmployee; 
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage; 

class ObservationController extends Controller
{
    public function index()
    {
        // Tetap menggunakan latest() agar inputan terbaru selalu di atas
        $observations = Observation::with(['company', 'workUnit', 'observer'])->latest()->get(); 
        return view('observations.index', compact('observations'));
    }

    public function create()
    {
        $companies = Company::all(); 
        $workUnits = WorkUnit::orderByRaw("CASE WHEN nama_unit LIKE 'UP3%' THEN 1 WHEN nama_unit LIKE 'ULP%' THEN 2 ELSE 3 END, nama_unit ASC")->get();
        $observers = K3lkEmployee::orderBy('nama_pegawai', 'asc')->get(); 
        
        return view('observations.create', compact('companies', 'workUnits', 'observers')); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_pekerjaan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'work_unit_id' => 'required|exists:work_units,id', 
            'lokasi_pekerjaan' => 'required',
            'company_id' => 'required|exists:companies,id', 
            'nama_personel_diobservasi' => 'required',
            'k3lk_employee_id' => 'required|exists:k3lk_employees,id',
            'dokumen_tersedia' => 'nullable|array', 
            'no_wp' => 'nullable|string|max:100',
            'dokumen_dilaksanakan_baik' => 'required',
            'review_bersama_pekerja' => 'required',
            'catatan' => 'nullable',
            'unsafe_actions_conditions' => 'nullable',
            'review_disampaikan' => 'nullable',
            'rekomendasi_perbaikan' => 'nullable',
            // Mendukung file dokumen dan foto dengan limit 5MB
            'bukti_dokumen' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', 
            'foto_review' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        $data['dokumen_tersedia'] = json_encode($data['dokumen_tersedia'] ?? []); 
        
        if ($request->hasFile('bukti_dokumen')) {
            $data['bukti_dokumen_path'] = $request->file('bukti_dokumen')->store('bukti_dokumen', 'public');
        }
        
        if ($request->hasFile('foto_review')) {
            $data['foto_review_path'] = $request->file('foto_review')->store('foto_review', 'public');
        }
        
        unset($data['bukti_dokumen'], $data['foto_review']); 
        
        Observation::create($data); 
        return redirect()->route('observations.index')->with('success', 'Data Observasi berhasil disimpan!');
    }

    public function dashboard()
    {
        $last30Days = now()->subDays(30);
        $allObservations = Observation::where('tanggal', '>=', $last30Days)->get();
        
        $totalAll = Observation::count();
        $totalObsThisMonth = $allObservations->count();
        $amanObs = $allObservations->where('dokumen_dilaksanakan_baik', 'Ya')->count();
        $tidakAmanObs = $allObservations->where('dokumen_dilaksanakan_baik', 'Tidak')->count();
        
        $complianceRate = ($totalObsThisMonth > 0) ? round(($amanObs / $totalObsThisMonth) * 100, 1) : 0;
        $latestObservations = Observation::latest()->take(5)->get();
        
        $reviewSelesai = Observation::where('review_bersama_pekerja', 'Ya')->count();
        $reviewTotal = Observation::count();
        $reviewCompletionRate = ($reviewTotal > 0) ? round(($reviewSelesai / $reviewTotal) * 100, 1) : 0;

        // --- PERBAIKAN GRAFIK TREN: Menggunakan urutan kronologis Tahun+Bulan ---
        $trendData = Observation::selectRaw("
                DATE_FORMAT(tanggal, '%M %Y') as bulan_tahun, 
                COUNT(*) as total, 
                DATE_FORMAT(tanggal, '%Y%m') as urutan
            ")
            ->where('tanggal', '>=', now()->subMonths(5)->startOfMonth())
            ->groupBy('bulan_tahun', 'urutan')
            ->orderBy('urutan', 'asc') // Urutkan 202512 sebelum 202601
            ->get();

        $labelsTrend = $trendData->pluck('bulan_tahun')->toArray(); 
        $dataTrend = $trendData->pluck('total')->toArray();   

        return view('dashboard', compact(
            'totalAll', 'totalObsThisMonth', 'amanObs', 'tidakAmanObs', 
            'complianceRate', 'latestObservations', 'reviewCompletionRate',
            'labelsTrend', 'dataTrend'
        ));
    }

    public function laporan(Request $request) { return view('reports.index'); }

    public function rekapitulasiJso(Request $request)
    {
        $tglAwal = $request->input('tgl_awal');
        $tglAkhir = $request->input('tgl_akhir');
        $unit = $request->input('unit'); 
        $statusAman = $request->input('status_aman'); 
        $perusahaan = $request->input('perusahaan'); 
        
        $query = Observation::with(['company', 'workUnit', 'observer']); 

        if ($tglAwal && $tglAkhir) {
            $query->whereBetween('tanggal', [$tglAwal, $tglAkhir]);
        }
        
        if (!empty($unit)) $query->where('work_unit_id', $unit); 
        if ($statusAman) $query->where('dokumen_dilaksanakan_baik', $statusAman);
        if (!empty($perusahaan)) $query->where('company_id', $perusahaan); 

        $semua_observasi = $query->latest()->get();
        $list_unit = WorkUnit::pluck('nama_unit', 'id');
        $list_perusahaan = Company::orderBy('nama', 'asc')->pluck('nama', 'id'); 

        return view('reports.rekapitulasi-jso', compact(
            'semua_observasi', 'tglAwal', 'tglAkhir', 'list_unit', 'unit', 'statusAman', 'list_perusahaan', 'perusahaan'
        ));
    }
    
    public function laporanBahaya(Request $request) { return $this->rekapitulasiJso($request); }

    public function laporanKinerjaVendor(Request $request)
    {
        $tglAwal = $request->input('tgl_awal');
        $tglAkhir = $request->input('tgl_akhir');
        $unit = $request->input('unit'); 
        $perusahaan = $request->input('perusahaan'); 

        $query = Observation::with(['company', 'workUnit', 'observer']);

        if ($tglAwal && $tglAkhir) $query->whereBetween('tanggal', [$tglAwal, $tglAkhir]);
        if (!empty($unit)) $query->where('work_unit_id', $unit);
        if (!empty($perusahaan)) $query->where('company_id', $perusahaan); 
        
        $semua_observasi = $query->get();
        $kinerja_perusahaan = $semua_observasi->groupBy('company_id')->map(function ($items) {
            $total = $items->count();
            $aman = $items->where('dokumen_dilaksanakan_baik', 'Ya')->count();
            $companyName = $items->first()->company->nama ?? 'N/A'; 
            return [
                'nama' => $companyName, 
                'total' => $total,
                'aman' => $aman,
                'tidak_aman' => $total - $aman,
                'persentase_aman' => $total > 0 ? round(($aman / $total) * 100, 1) : 0, 
            ];
        });
        
        $list_unit = WorkUnit::pluck('nama_unit', 'id');
        $list_perusahaan = Company::orderBy('nama', 'asc')->pluck('nama', 'id'); 

        return view('reports.kinerja-vendor', compact('kinerja_perusahaan', 'tglAwal', 'tglAkhir', 'list_unit', 'unit', 'list_perusahaan', 'perusahaan'));
    }

    public function laporanKelengkapanDokumen(Request $request)
    {
        $tglAwal = $request->input('tgl_awal');
        $tglAkhir = $request->input('tgl_akhir');
        $filterDokumen = $request->input('filter_dokumen');
        $perusahaan = $request->input('perusahaan'); 
        $namaPersonel = $request->input('nama_personel'); 

        $query = Observation::with(['company']); 

        if ($tglAwal && $tglAkhir) {
            $query->whereBetween('tanggal', [$tglAwal, $tglAkhir]);
        }
        
        if (!empty($perusahaan)) $query->where('company_id', $perusahaan); 
        if (!empty($namaPersonel)) $query->where('nama_personel_diobservasi', $namaPersonel);

        $observations = $query->latest()->get();

        if ($filterDokumen == 'Lengkap') {
            $observations = $observations->filter(fn($item) => count(json_decode($item->dokumen_tersedia, true) ?? []) === 5);
        } elseif ($filterDokumen == 'Tidak Lengkap') {
            $observations = $observations->filter(fn($item) => count(json_decode($item->dokumen_tersedia, true) ?? []) < 5);
        }

        $semua_observasi = $observations;
        $list_perusahaan = Company::orderBy('nama', 'asc')->pluck('nama', 'id'); 
        $list_personel = Observation::distinct()->orderBy('nama_personel_diobservasi', 'asc')->pluck('nama_personel_diobservasi');

        return view('reports.kelengkapan-dokumen', compact(
            'semua_observasi', 'tglAwal', 'tglAkhir', 'filterDokumen', 
            'list_perusahaan', 'perusahaan', 'list_personel', 'namaPersonel'
        ));
    }

    public function laporanRiwayatIndividu(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $namaFilter = $request->input('nama_personel'); 
        $perusahaan = $request->input('perusahaan');

        $query = Observation::with(['company']);

        if ($startDate && $endDate) $query->whereBetween('tanggal', [$startDate, $endDate]);
        if ($namaFilter) $query->where('nama_personel_diobservasi', $namaFilter); 
        if ($perusahaan) $query->where('company_id', $perusahaan);
        
        $observations = $query->latest()->get();
        $riwayat_individu = [];

        foreach ($observations->groupBy('nama_personel_diobservasi') as $personelName => $items) {
            if (empty($personelName)) continue;
            
            $rekomendasi = $items->whereNotNull('rekomendasi_perbaikan')->where('rekomendasi_perbaikan', '!=', '')->first();

            $riwayat_individu[$personelName] = [
                'total' => $items->count(),
                'tidak_aman' => $items->where('dokumen_dilaksanakan_baik', 'Tidak')->count(),
                'rekomendasi_terakhir' => $rekomendasi->rekomendasi_perbaikan ?? 'Tidak ada rekomendasi',
                'perusahaan_nama' => $items->first()->company->nama ?? 'N/A', 
            ];
        }

        $list_personel = Observation::distinct()->orderBy('nama_personel_diobservasi', 'asc')->pluck('nama_personel_diobservasi');
        $list_perusahaan = Company::orderBy('nama', 'asc')->pluck('nama', 'id');

        return view('reports.riwayat-individu', compact('riwayat_individu', 'startDate', 'endDate', 'list_personel', 'namaFilter', 'list_perusahaan', 'perusahaan'));
    }

    public function laporanEvidence(Request $request)
    {
        $tglAwal = $request->input('tgl_awal');
        $tglAkhir = $request->input('tgl_akhir');
        $perusahaan = $request->input('perusahaan'); 
        $cariPekerjaan = $request->input('cari_pekerjaan'); 
        
        $query = Observation::with(['company', 'observer']); 

        if ($tglAwal && $tglAkhir) {
            $query->whereBetween('tanggal', [$tglAwal, $tglAkhir]);
        }
        
        if (!empty($perusahaan)) {
            $query->where('company_id', $perusahaan);
        }

        if (!empty($cariPekerjaan)) {
            $query->where('jenis_pekerjaan', 'LIKE', '%' . $cariPekerjaan . '%');
        }

        $semua_observasi = $query->latest()->get();
        $list_perusahaan = Company::orderBy('nama', 'asc')->pluck('nama', 'id');

        return view('reports.evidence', compact(
            'semua_observasi', 'tglAwal', 'tglAkhir', 'list_perusahaan', 'perusahaan', 'cariPekerjaan'
        ));
    }

    public function cetakLaporan(Request $request)
    {
        ini_set('memory_limit', '512M'); 
        set_time_limit(300);

        $startDate = $request->tgl_awal ?? $request->start_date;
        $endDate = $request->tgl_akhir ?? $request->end_date;
        $jenis = $request->jenis;
        $filterDokumen = $request->input('filter_dokumen');
        $unit = $request->input('unit'); 
        $statusAman = $request->input('status_aman');
        $perusahaan = $request->input('perusahaan'); 
        $namaFilter = $request->input('nama_personel') ?? $request->nama_personel_diobservasi; 
        $cariPekerjaan = $request->input('cari_pekerjaan'); 
        
        $query = Observation::with(['company', 'workUnit', 'observer']); 

        if ($startDate && $endDate) $query->whereBetween('tanggal', [$startDate, $endDate]);

        if (!empty($unit)) $query->where('work_unit_id', $unit); 
        if ($statusAman) $query->where('dokumen_dilaksanakan_baik', $statusAman);
        if (!empty($perusahaan)) $query->where('company_id', $perusahaan); 
        if ($namaFilter) $query->where('nama_personel_diobservasi', $namaFilter); 
        if (!empty($cariPekerjaan)) $query->where('jenis_pekerjaan', 'LIKE', '%' . $cariPekerjaan . '%');

        if ($jenis == 'evidence') {
            $semua_observasi = $query->latest()->take(100)->get(); 
        } else {
            $semua_observasi = $query->latest()->get();
        }

        if ($jenis == 'dokumen') {
            if ($filterDokumen == 'Lengkap') {
                $semua_observasi = $semua_observasi->filter(fn($i) => count(json_decode($i->dokumen_tersedia, true) ?? []) === 5);
            } elseif ($filterDokumen == 'Tidak Lengkap') {
                $semua_observasi = $semua_observasi->filter(fn($i) => count(json_decode($i->dokumen_tersedia, true) ?? []) < 5);
            }
        }

        $total_aman = $semua_observasi->where('dokumen_dilaksanakan_baik', 'Ya')->count();
        $total_tidak_aman = $semua_observasi->where('dokumen_dilaksanakan_baik', 'Tidak')->count();

        $data = compact('semua_observasi', 'startDate', 'endDate', 'statusAman', 'total_aman', 'total_tidak_aman');
        $data['tglAwal'] = $startDate;
        $data['tglAkhir'] = $endDate;

        if ($jenis == 'rekapitulasi') {
            $viewName = 'reports.pdf_rekapitulasi';
        } elseif ($jenis == 'vendor') {
            $data['kinerja_perusahaan'] = $semua_observasi->groupBy('company_id')->map(function ($items) {
                $aman = $items->where('dokumen_dilaksanakan_baik', 'Ya')->count();
                return [
                    'nama' => $items->first()->company->nama ?? 'N/A',
                    'total' => $items->count(), 
                    'aman' => $aman, 
                    'tidak_aman' => $items->count() - $aman,
                    'persentase_aman' => $items->count() > 0 ? round(($aman / $items->count()) * 100, 1) : 0, 
                ];
            });
            $viewName = 'reports.pdf_vendor'; 
        } elseif ($jenis == 'individu') {
            $data['riwayat_individu'] = $semua_observasi->groupBy('nama_personel_diobservasi')->map(function ($items) {
                $rekomendasi = $items->whereNotNull('rekomendasi_perbaikan')->where('rekomendasi_perbaikan', '!=', '')->first();
                return [
                    'total' => $items->count(), 
                    'tidak_aman' => $items->where('dokumen_dilaksanakan_baik', 'Tidak')->count(),
                    'rekomendasi_terakhir' => $rekomendasi->rekomendasi_perbaikan ?? 'N/A',
                    'perusahaan_nama' => $items->first()->company->nama ?? 'N/A',
                ];
            });
            $viewName = 'reports.pdf_individu';
        } elseif ($jenis == 'dokumen') {
            $viewName = 'reports.pdf_dokumen';
        } elseif ($jenis == 'evidence') {
            $viewName = 'reports.pdf_evidence';
        } else {
            $viewName = 'reports.pdf_rekapitulasi';
        }
        
        $pdf = Pdf::loadView($viewName, $data);
        $jenis == 'dokumen' ? $pdf->setPaper('a4', 'landscape') : $pdf->setPaper('a4', 'portrait'); 
        
        return $pdf->stream('Laporan_JSO_' . ucfirst($jenis) . '.pdf');
    }

    public function edit(Observation $observation)
    {
        $companies = Company::all(); 
        $workUnits = WorkUnit::orderByRaw("CASE WHEN nama_unit LIKE 'UP3%' THEN 1 WHEN nama_unit LIKE 'ULP%' THEN 2 ELSE 3 END, nama_unit ASC")->get();
        $observers = K3lkEmployee::orderBy('nama_pegawai', 'asc')->get(); 

        return view('observations.edit', compact('observation', 'companies', 'workUnits', 'observers')); 
    }
    
    public function show(Observation $observation) { return view('observations.show', compact('observation')); }

    public function update(Request $request, Observation $observation)
    {
        $validated = $request->validate([
            'jenis_pekerjaan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'work_unit_id' => 'required|exists:work_units,id', 
            'lokasi_pekerjaan' => 'required',
            'company_id' => 'required|exists:companies,id', 
            'nama_personel_diobservasi' => 'required',
            'k3lk_employee_id' => 'required|exists:k3lk_employees,id',
            'dokumen_tersedia' => 'nullable|array',
            'no_wp' => 'nullable|string|max:100',
            'dokumen_dilaksanakan_baik' => 'required',
            'review_bersama_pekerja' => 'required',
            'catatan' => 'nullable',
            'unsafe_actions_conditions' => 'nullable',
            'review_disampaikan' => 'nullable',
            'rekomendasi_perbaikan' => 'nullable',
            'bukti_dokumen' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', 
            'foto_review' => 'nullable|image|max:2048',
        ]);

        $data = $validated;
        $data['dokumen_tersedia'] = json_encode($data['dokumen_tersedia'] ?? []);
        
        if ($request->hasFile('bukti_dokumen')) {
            if ($observation->bukti_dokumen_path) Storage::disk('public')->delete($observation->bukti_dokumen_path);
            $data['bukti_dokumen_path'] = $request->file('bukti_dokumen')->store('bukti_dokumen', 'public');
        }

        if ($request->hasFile('foto_review')) {
            if ($observation->foto_review_path) Storage::disk('public')->delete($observation->foto_review_path);
            $data['foto_review_path'] = $request->file('foto_review')->store('foto_review', 'public');
        }
        
        unset($data['bukti_dokumen'], $data['foto_review']);
        $observation->update($data); 

        return redirect()->route('observations.index')->with('success', 'Data Observasi berhasil diperbarui!');
    }

    public function destroy(Observation $observation)
    {
        if ($observation->bukti_dokumen_path) Storage::disk('public')->delete($observation->bukti_dokumen_path);
        if ($observation->foto_review_path) Storage::disk('public')->delete($observation->foto_review_path); 
        $observation->delete();
        return redirect()->route('observations.index')->with('success', 'Data Observasi berhasil dihapus.');
    }
}