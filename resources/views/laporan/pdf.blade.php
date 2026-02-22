<!DOCTYPE html>
<html>
<head>
    <title>Laporan Laboratorium</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #065f46; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #065f46; }
        .header p { margin: 5px 0 0; color: #666; font-size: 12px; }
        
        .section-title { font-size: 14px; font-weight: bold; margin-top: 20px; margin-bottom: 10px; color: #065f46; border-left: 4px solid #065f46; padding-left: 8px; }
        
        /* Summary Cards Layout menggunakan Table agar rapi di PDF */
        .summary-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary-table td { width: 25%; padding: 10px; border: 1px solid #ddd; background-color: #f9fafb; text-align: center; }
        .summary-val { font-size: 20px; font-weight: bold; color: #1f2937; display: block; }
        .summary-label { font-size: 10px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }

        /* Data Tables */
        table.data { width: 100%; border-collapse: collapse; font-size: 12px; }
        table.data th, table.data td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; }
        table.data th { background-color: #064e3b; color: white; }
        table.data tr:nth-child(even) { background-color: #f3f4f6; }
        
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 10px; color: white; }
        .bg-red { background-color: #ef4444; }
        .bg-green { background-color: #10b981; }
        .bg-gray { background-color: #6b7280; }
        
        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 10px; text-align: center; color: #9ca3af; }
    </style>
</head>
<body>

    <div class="header">
        <h1>SIM-LAB LAPORAN & ANALITIK</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    <table class="summary-table">
        <tr>
            <td>
                <span class="summary-label">Total Sesi</span>
                <span class="summary-val">{{ $summary['total_sesi']['value'] }}</span>
            </td>
            <td>
                <span class="summary-label">Total Partisipan</span>
                <span class="summary-val">{{ $summary['total_partisipan']['value'] }}</span>
            </td>
            <td>
                <span class="summary-label">Utilisasi Rata-rata</span>
                <span class="summary-val">{{ $summary['utilisasi_rata']['value'] }}</span>
            </td>
            <td>
                <span class="summary-label">Compliance Rate</span>
                <span class="summary-val">{{ $summary['compliance']['value'] }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Utilisasi Ruangan</div>
    <table class="data">
        <thead>
            <tr>
                <th>Nama Lab</th>
                <th>Persentase Penggunaan</th>
                <th>Status Target (75%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lab_utilizations as $lab)
            <tr>
                <td>{{ $lab['name'] }}</td>
                <td>{{ $lab['percentage'] }}%</td>
                <td>
                    @if($lab['percentage'] >= 75)
                        <span style="color: green;">Achieved</span>
                    @else
                        <span style="color: orange;">Under Target</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 20px;">
        <tr>
            <td style="width: 50%; vertical-align: top; padding-right: 10px; border: none;">
                <div class="section-title" style="margin-top:0;">Statistik Alat (Top 3)</div>
                <table class="data">
                    <thead>
                        <tr>
                            <th>Alat</th>
                            <th>Avg Usage</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipment_stats as $alat)
                        <tr>
                            <td>{{ $alat['name'] }}</td>
                            <td>{{ $alat['avg_usage'] }}%</td>
                            <td>
                                @php
                                    $color = match($alat['status']) {
                                        'Critical' => 'bg-red',
                                        'High' => 'bg-green',
                                        default => 'bg-gray'
                                    };
                                @endphp
                                <span class="badge {{ $color }}">{{ $alat['status'] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top; padding-left: 10px; border: none;">
                <div class="section-title" style="margin-top:0;">Ringkasan K3</div>
                <table class="data">
                    <thead>
                        <tr>
                            <th>Metrik</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($k3_summary as $k3)
                        <tr>
                            <td>{{ $k3['title'] }}</td>
                            <td><strong>{{ $k3['value'] }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh sistem SIM-LAB.
    </div>

</body>
</html>