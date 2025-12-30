<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekapitulasi JSO</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        
        /* Gaya Kop Surat Resmi */
        .kop-surat { border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; overflow: hidden; }
        .logo-pln { float: left; width: 80px; margin-right: 15px; }
        .instansi { float: left; margin-top: 5px; }
        .instansi h1 { font-size: 14px; margin: 0; text-transform: uppercase; }
        .instansi p { font-size: 11px; margin: 2px 0; font-weight: bold; }
        .clear { clear: both; }

        .title-laporan { text-align: center; font-size: 14px; font-weight: bold; text-decoration: underline; margin-bottom: 15px; text-transform: uppercase; }
        .info-periode { text-align: center; font-size: 11px; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th { background-color: #f2f2f2; border: 1px solid #000; padding: 8px; text-transform: uppercase; font-size: 9px; font-weight: bold; }
        td { border: 1px solid #000; padding: 8px; vertical-align: top; word-wrap: break-word; }
        .text-center { text-align: center; }
        .status-aman { color: #000; font-weight: bold; }
        .status-bahaya { color: #000; font-weight: bold; text-decoration: underline; }
        .footer-date { margin-top: 30px; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="{{ public_path('images/logo-pln.png') }}" class="logo-pln">
        <div class="instansi">
            <h1>PT. PLN (Persero)</h1>
            <p>Unit Induk Distribusi Kalimantan Selatan & Tengah</p>
            <p>UP3 Banjarmasin</p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="title-laporan">Laporan Rekapitulasi Data Observasi & Temuan Bahaya</div>
    <div class="info-periode">
        Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : 'Semua' }} 
        s/d {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : 'Semua' }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Data Pekerjaan / Unit</th>
                <th width="20%">Pelaksana</th>
                <th width="10%">Status</th>
                <th width="35%">Detail Temuan & Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($semua_observasi as $obs)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>
                    <strong>{{ $obs->workUnit->nama_unit ?? '-' }}</strong><br>
                    {{ $obs->jenis_pekerjaan }}<br>
                    <small>Tgl: {{ \Carbon\Carbon::parse($obs->tanggal)->format('d/m/Y') }}</small>
                </td>
                <td>{{ $obs->company->nama ?? '-' }}</td>
                <td class="text-center">
                    @if($obs->dokumen_dilaksanakan_baik == 'Ya')
                        <span class="status-aman">AMAN</span>
                    @else
                        <span class="status-bahaya">BAHAYA</span>
                    @endif
                </td>
                <td>
                    @if($obs->dokumen_dilaksanakan_baik == 'Tidak')
                        <strong>Temuan:</strong> {{ $obs->unsafe_actions_conditions ?? '-' }}<br>
                        <strong>Saran:</strong> {{ $obs->rekomendasi_perbaikan ?? '-' }}
                    @else
                        <span style="font-style: italic; color: #666;">Kondisi Aman</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Data tidak ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-date">
        Banjarmasin, {{ date('d F Y') }}
    </div>
</body>
</html>