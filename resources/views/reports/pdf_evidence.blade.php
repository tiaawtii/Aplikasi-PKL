<!DOCTYPE html>
<html>
<head>
    <title>Laporan Evidence Foto Lapangan</title>
    <style>
        @page { 
            margin: 1cm; 
            size: a4 portrait;
        }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 10px; 
            color: #333; 
            line-height: 1.2; 
        }
        
        /* Kop Surat Resmi */
        .kop-surat { 
            border-bottom: 2px solid #000; 
            padding-bottom: 8px; 
            margin-bottom: 15px; 
        }
        .logo-pln { 
            float: left; 
            width: 60px; 
        }
        .instansi { 
            float: left; 
            margin-left: 12px; 
        }
        .instansi h1 { 
            font-size: 12px; 
            margin: 0; 
            text-transform: uppercase; 
            font-weight: bold;
        }
        .instansi p { 
            font-size: 10px; 
            margin: 1px 0; 
        }
        .clear { clear: both; }

        .title-laporan { 
            text-align: center; 
            font-size: 12px; 
            font-weight: bold; 
            text-decoration: underline; 
            margin-bottom: 3px; 
            text-transform: uppercase; 
        }
        .info-periode { 
            text-align: center; 
            font-size: 9px; 
            margin-bottom: 15px; 
        }

        /* Container Item Evidence */
        .evidence-card {
            border: 1px solid #000;
            margin-bottom: 15px;
            padding: 8px;
            page-break-inside: avoid;
        }
        
        table { width: 100%; border-collapse: collapse; }
        
        .data-info td {
            vertical-align: top;
            padding: 1px 0;
        }
        .label {
            font-weight: bold;
            width: 100px;
        }
        
        /* Foto Bagian */
        .photo-section {
            margin-top: 8px;
            text-align: left;
        }
        .photo-box {
            display: inline-block;
            width: 155px; 
            margin-right: 10px;
            text-align: center;
            vertical-align: top;
        }
        .img-evidence {
            width: 150px; 
            height: 100px;
            object-fit: cover;
            border: 1px solid #000;
        }
        .photo-caption {
            font-size: 8px;
            font-weight: bold;
            margin-top: 2px;
        }
        
        .status-text {
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #000;
            padding: 1px 4px;
            background: #eee;
        }

        .footer-date { 
            margin-top: 30px; 
            text-align: right; 
            font-size: 10px; 
            padding-right: 10px;
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

    <div class="title-laporan">Laporan Verifikasi Evidence & Foto Lapangan</div>
    <div class="info-periode">
        Periode: {{ $startDate ?? 'Semua' }} s/d {{ $endDate ?? 'Semua' }}
    </div>

    @forelse($semua_observasi as $obs)
    <div class="evidence-card">
        <table class="data-info">
            <tr>
                <td class="label">Pelaksana</td>
                <td>: <strong>{{ $obs->company->nama ?? 'N/A' }}</strong></td>
                <td class="label" style="width:80px;">Tanggal</td>
                <td>: {{ \Carbon\Carbon::parse($obs->tanggal)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Pekerjaan</td>
                <td colspan="3">: {{ $obs->jenis_pekerjaan }}</td>
            </tr>
            <tr>
                <td class="label">Nama Personel</td>
                <td>: {{ $obs->nama_personel_diobservasi }}</td>
                <td class="label">Status</td>
                <td>: <span class="status-text">{{ $obs->dokumen_dilaksanakan_baik == 'Ya' ? 'AMAN' : 'BAHAYA' }}</span></td>
            </tr>
        </table>

        <div class="photo-section">
            <div class="photo-box">
                @if($obs->bukti_dokumen_path)
                    @php 
                        $extension = pathinfo($obs->bukti_dokumen_path, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png']);
                    @endphp

                    @if($isImage)
                        <img src="{{ public_path('storage/' . $obs->bukti_dokumen_path) }}" class="img-evidence">
                        <div class="photo-caption">FOTO DOKUMEN</div>
                    @else
                        {{-- Tampilan jika lampiran bukan foto (PDF/DOC) agar tidak pecah di PDF --}}
                        <div style="width:150px; height:100px; border:1px solid #000; line-height:20px; font-size:8px; text-align:center; padding-top:35px; background-color: #f9f9f9;">
                            DOKUMEN LAMPIRAN<br>({{ strtoupper($extension) }})
                        </div>
                        <div class="photo-caption">FILE DOKUMEN</div>
                    @endif
                @else
                    <div style="width:150px; height:100px; border:1px solid #000; line-height:100px; font-size:8px; text-align:center;">TIDAK ADA FOTO</div>
                @endif
            </div>

            <div class="photo-box">
                @if($obs->foto_review_path)
                    <img src="{{ public_path('storage/' . $obs->foto_review_path) }}" class="img-evidence">
                    <div class="photo-caption">FOTO REVIEW</div>
                @else
                    <div style="width:150px; height:100px; border:1px solid #000; line-height:100px; font-size:8px; text-align:center;">TIDAK ADA FOTO</div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <p style="text-align:center;">Data tidak ditemukan.</p>
    @endforelse

    <div class="footer-date">
        Banjarmasin, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}
    </div>
</body>
</html>