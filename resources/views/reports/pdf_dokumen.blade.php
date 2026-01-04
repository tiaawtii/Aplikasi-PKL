<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kelengkapan Dokumen</title>
    <style>
        @page { 
            margin: 1.2cm; 
            size: a4 portrait; 
        }
        
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 10px; 
            color: #333; 
            line-height: 1.4; 
        }
        
        .kop-surat { 
            border-bottom: 3px solid #000; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }
        .logo-pln { 
            float: left; 
            width: 60px; 
        }
        .instansi { 
            float: left; 
            margin-left: 15px; 
        }
        .instansi h1 { 
            font-size: 14px; 
            margin: 0; 
            text-transform: uppercase; 
            font-weight: bold; 
        }
        .instansi p { 
            font-size: 10px; 
            margin: 1px 0; 
        }
        .clear { 
            clear: both; 
        }

        .title-laporan { 
            text-align: center; 
            font-size: 12px; 
            font-weight: bold; 
            text-decoration: underline; 
            margin-bottom: 5px; 
            text-transform: uppercase; 
        }
        .info-periode { 
            text-align: center; 
            font-size: 9px; 
            margin-bottom: 15px; 
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            table-layout: fixed; 
        }
        th { 
            background-color: #f2f2f2; 
            border: 1px solid #000; 
            padding: 5px; 
            text-transform: uppercase; 
            font-size: 8px; 
            font-weight: bold; 
        }
        td { 
            border: 1px solid #000; 
            padding: 5px; 
            vertical-align: middle; 
            word-wrap: break-word; 
            font-size: 9px;
        }
        .text-center { 
            text-align: center; 
        }
        
        .check { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 11px; 
        }
        .footer-date { 
            margin-top: 30px; 
            text-align: right; 
            font-size: 10px; 
        }
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

    <div class="title-laporan">Laporan Kelengkapan Dokumen K3 Kerja</div>
    <div class="info-periode">
        {{-- Menggunakan format d-m-Y untuk periode angka --}}
        Periode: {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d-m-Y') : 'Semua' }} 
        s/d {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d-m-Y') : 'Semua' }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="28%">Pelaksana & Nama Personel</th>
                <th width="10%">Tanggal</th>
                <th width="14%">No. WP</th>
                <th width="6%">WP</th>
                <th width="6%">SOP</th>
                <th width="6%">JSA</th>
                <th width="6%">IK</th>
                <th width="6%">IBPPR</th>
                <th width="14%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($semua_observasi as $obs)
                @php $docs = json_decode($obs->dokumen_tersedia, true) ?? []; @endphp
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>
                    <div style="font-weight: bold; text-transform: uppercase;">{{ $obs->company->nama ?? 'N/A' }}</div>
                    <div style="font-size: 8px; color: #555;">Personel: {{ $obs->nama_personel_diobservasi }}</div>
                </td>
                <td class="text-center">{{ \Carbon\Carbon::parse($obs->tanggal)->format('d-m-Y') }}</td>
                
                <td class="text-center" style="font-size: 8px; font-weight: bold; color: #065f46;">
                    {{ $obs->no_wp ?? '-' }}
                </td>

                <td class="text-center check" style="color: {{ in_array('WP', $docs) ? '#059669' : '#dc2626' }};">
                    {{ in_array('WP', $docs) ? '✔' : '✘' }}
                </td>
                <td class="text-center check" style="color: {{ in_array('SOP', $docs) ? '#059669' : '#dc2626' }};">
                    {{ in_array('SOP', $docs) ? '✔' : '✘' }}
                </td>
                <td class="text-center check" style="color: {{ in_array('JSA', $docs) ? '#059669' : '#dc2626' }};">
                    {{ in_array('JSA', $docs) ? '✔' : '✘' }}
                </td>
                <td class="text-center check" style="color: {{ in_array('IK', $docs) ? '#059669' : '#dc2626' }};">
                    {{ in_array('IK', $docs) ? '✔' : '✘' }}
                </td>
                <td class="text-center check" style="color: {{ in_array('IBPPR', $docs) ? '#059669' : '#dc2626' }};">
                    {{ in_array('IBPPR', $docs) ? '✔' : '✘' }}
                </td>
                
                <td class="text-center" style="font-weight: bold; font-size: 8px;">
                    {{ count($docs) == 5 ? 'LENGKAP' : 'TIDAK LENGKAP' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 20px;">Data tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-date">
        {{-- Menggunakan ISO format dengan locale Indonesia untuk nama bulan --}}
        Banjarmasin, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}
    </div>
</body>
</html>