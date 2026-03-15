<!DOCTYPE html>
<html>
<head>
    <title>Laporan Medis - {{ $child->nama }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #1e3a8a; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px solid #1e3a8a; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; text-transform: uppercase; font-size: 20px; }
        .header p { margin: 5px 0; font-size: 10px; color: #64748b; font-weight: bold; letter-spacing: 1px; }
        
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: collapse; }
        .info-table td { padding: 5px; font-size: 11px; vertical-align: top; }
        .label { font-weight: bold; color: #1e3a8a; width: 120px; text-transform: uppercase; font-size: 9px; }
        
        .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .main-table th { background: #1e3a8a; color: white; padding: 10px; font-size: 10px; text-transform: uppercase; text-align: center; }
        .main-table td { padding: 8px; border: 1px solid #e2e8f0; font-size: 10px; text-align: center; color: #334155; }
        .main-table tr:nth-child(even) { background-color: #f8fafc; }
        
        .status-badge { padding: 3px 6px; border-radius: 4px; font-weight: bold; font-size: 8px; text-transform: uppercase; }
        .status-normal { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .status-stunting { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .status-tinggi { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        
        /* Area Tanda Tangan Petugas */
        .signature-wrapper { margin-top: 50px; width: 100%; }
        .signature-box { float: right; width: 200px; text-align: center; font-size: 11px; }
        .signature-space { height: 60px; }
        .signature-name { font-weight: bold; text-decoration: underline; text-transform: uppercase; }

        .footer { clear: both; margin-top: 50px; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Hasil Pemantauan Gizi Anak</h1>
        <p>SISTEM INFORMASI STUNTING - REKAM MEDIS DIGITAL</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Nama</td>
            <td>: <strong>{{ strtoupper($child->nama) }}</strong></td>
            <td class="label">Petugas</td>
            <td>: {{ auth()->user()->name ?? 'Administrator' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td>: {{ $child->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
            <td class="label">ID Registrasi</td>
            <td>: MK-{{ str_pad($child->id, 4, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Lahir</td>
            <td>: {{ \Carbon\Carbon::parse($child->tgl_lahir)->translatedFormat('d F Y') }}</td>
            <td class="label">Tanggal Cetak</td>
            <td>: {{ date('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <h3 style="font-size: 12px; border-left: 4px solid #1e3a8a; padding-left: 10px; margin-bottom: 10px; text-transform: uppercase;">Riwayat Pertumbuhan</h3>
    
    <table class="main-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Periksa</th>
                <th>Umur</th>
                <th>Tinggi Badan</th>
                <th>Berat Badan</th>
                <th>Status Gizi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($child->records->sortByDesc('created_at') as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $record->created_at->format('d/m/Y') }}</td>
                <td>{{ $record->umur_bulan }} Bulan</td>
                <td>{{ $record->tinggi_badan }} cm</td>
                <td>{{ $record->berat_badan ?? '-' }} kg</td>
                <td>
                    <span class="status-badge 
                        {{ $record->status_stunting == 'Normal' ? 'status-normal' : '' }}
                        {{ $record->status_stunting == 'Tinggi' ? 'status-tinggi' : '' }}
                        {{ str_contains($record->status_stunting, 'Pendek') ? 'status-stunting' : '' }}">
                        {{ $record->status_stunting }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-wrapper">
        <div class="signature-box">
            <p>Dicetak di Banjarnegara,</p>
            <p>Petugas Kesehatan,</p>
            <div class="signature-space"></div>
            <p class="signature-name">{{ auth()->user()->name ?? 'Admin Sistem' }}</p>
            <p>NIP. ............................</p>
        </div>
    </div>

    <div class="footer">
        <p>Laporan ini sah dan dihasilkan secara sistematis oleh Aplikasi SI-STUNTING.</p>
        <p>© {{ date('Y') }} - All Rights Reserved</p>
    </div>
</body>
</html>