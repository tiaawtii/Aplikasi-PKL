<!DOCTYPE html>
<html>
<head>
    <title>Laporan Riwayat Individu</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #000; line-height: 1.4; }
        .kop-surat { border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; overflow: hidden; }
        .logo-pln { float: left; width: 70px; margin-right: 15px; }
        .instansi { float: left; margin-top: 5px; }
        .instansi h1 { font-size: 14px; margin: 0; text-transform: uppercase; }
        .instansi p { font-size: 10px; margin: 1px 0; font-weight: bold; }
        .clear { clear: both; }
        .title-laporan { text-align: center; font-size: 13px; font-weight: bold; text-decoration: underline; margin-bottom: 20px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #f2f2f2; border: 1px solid #000; padding: 8px; text-transform: uppercase; font-size: 9px; }
        td { border: 1px solid #000; padding: 8px; vertical-align: middle; text-align: center; }
        .text-left { text-align: left; }
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

    <div class="title-laporan">Laporan Riwayat Kinerja Personel (Individu)</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Personel</th>
                <th>Perusahaan</th>
                <th>Total Observasi</th>
                <th>Total Bahaya</th>
                <th>Rekomendasi Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat_individu as $nama => $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-left"><strong>{{ $nama }}</strong></td>
                <td class="text-left">{{ $data['perusahaan_nama'] }}</td>
                <td>{{ $data['total'] }} Kali</td>
                <td style="{{ $data['tidak_aman'] > 0 ? 'font-weight:bold;' : '' }}">{{ $data['tidak_aman'] }}</td>
                <td class="text-left">{{ $data['rekomendasi_terakhir'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        {{-- PERBAIKAN: Memastikan bulan menggunakan Bahasa Indonesia --}}
        Banjarmasin, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
    </div>
</body>
</html>