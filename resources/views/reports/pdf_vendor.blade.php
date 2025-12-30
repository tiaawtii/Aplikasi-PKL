<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kinerja Vendor</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; }
        .kop-surat { border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; overflow: hidden; }
        .logo-pln { float: left; width: 80px; margin-right: 15px; }
        .instansi { float: left; margin-top: 5px; }
        .instansi h1 { font-size: 14px; margin: 0; text-transform: uppercase; }
        .instansi p { font-size: 11px; margin: 2px 0; font-weight: bold; }
        .clear { clear: both; }

        .title-laporan { text-align: center; font-size: 14px; font-weight: bold; text-decoration: underline; margin-bottom: 15px; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background-color: #f2f2f2; border: 1px solid #000; padding: 10px; text-transform: uppercase; font-size: 10px; }
        td { border: 1px solid #000; padding: 10px; text-align: center; }
        .text-left { text-align: left; }
        .summary { margin-bottom: 15px; font-weight: bold; }
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

    <div class="title-laporan">Laporan Kinerja Keselamatan Perusahaan Pelaksana (Vendor)</div>
    
    <div class="summary">
        Ringkasan Periode: {{ $startDate ?? 'Awal' }} s/d {{ $endDate ?? 'Sekarang' }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="50%">Nama Perusahaan Pelaksana</th>
                <th width="15%">Total Obs</th>
                <th width="10%">Aman</th>
                <th width="10%">Bahaya</th>
                <th width="15%">Kepatuhan (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kinerja_perusahaan as $item)
            <tr>
                <td class="text-left"><strong>{{ $item['nama'] }}</strong></td>
                <td>{{ $item['total'] }}</td>
                <td>{{ $item['aman'] }}</td>
                <td>{{ $item['tidak_aman'] }}</td>
                <td><strong>{{ $item['persentase_aman'] }}%</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        Banjarmasin, {{ date('d F Y') }}<br><br><br><br>
    </div>
</body>
</html>