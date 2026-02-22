<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventori Lab FKG</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #111827;
        }
        h1, h2, h3, h4 { margin: 0; padding: 0; }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 16px;
            margin-bottom: 4px;
        }
        .header h2 {
            font-size: 13px;
            font-weight: normal;
            margin-bottom: 2px;
        }
        .meta {
            font-size: 10px;
            margin-bottom: 10px;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 16px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 4px 6px;
            vertical-align: top;
        }
        th {
            background: #ecfdf5;
            font-size: 10px;
        }
        td {
            font-size: 10px;
        }
        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 4px;
            font-size: 12px;
        }
        .small {
            font-size: 9px;
            color: #6b7280;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>LAPORAN INVENTORI LAB FKG</h1>
    <h2>Peralatan &amp; Bahan Habis Pakai</h2>
</div>

<div class="meta">
    Tanggal cetak: {{ $tanggalCetak }}
</div>

{{-- ================== BAGIAN A: PERALATAN ================== --}}
<div class="section-title">A. PERALATAN</div>

<table>
    <thead>
    <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 18%;">Kode</th>
        <th>Nama Peralatan</th>
        <th style="width: 14%;">Kategori</th>
        <th style="width: 16%;">Lokasi</th>
        <th style="width: 10%;">Status</th>
        <th style="width: 12%;">Kalibrasi Terakhir</th>
        <th style="width: 12%;">Kalibrasi Berikutnya</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($equipments as $idx => $eq)
        <tr>
            <td align="center">{{ $idx + 1 }}</td>
            <td>{{ $eq->code }}</td>
            <td>{{ $eq->name }}</td>
            <td>{{ $eq->category }}</td>
            <td>{{ $eq->location }}</td>
            <td>{{ $eq->status }}</td>
            <td>
                {{ $eq->last_calibration_date
                    ? \Carbon\Carbon::parse($eq->last_calibration_date)->format('Y-m-d')
                    : '-' }}
            </td>
            <td>
                {{ $eq->next_calibration_date
                    ? \Carbon\Carbon::parse($eq->next_calibration_date)->format('Y-m-d')
                    : '-' }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" align="center" class="small">
                Belum ada data peralatan.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

{{-- ================== BAGIAN B: BAHAN HABIS PAKAI ================== --}}
<div class="section-title">B. BAHAN HABIS PAKAI</div>

<table>
    <thead>
    <tr>
        <th style="width: 5%;">No</th>
        <th style="width: 18%;">Kode</th>
        <th>Nama Bahan</th>
        <th style="width: 14%;">Kategori</th>
        <th style="width: 16%;">Stok</th>
        <th style="width: 12%;">Batch / Lot</th>
        <th style="width: 12%;">Kedaluwarsa</th>
        <th style="width: 13%;">Status Stok</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($consumables as $idx => $sp)
        @php
            if ($sp->stock <= 0) {
                $stokLabel = 'Habis';
            } elseif ($sp->stock <= $sp->min_stock) {
                $stokLabel = 'Rendah';
            } else {
                $stokLabel = 'Cukup';
            }
        @endphp
        <tr>
            <td align="center">{{ $idx + 1 }}</td>
            <td>{{ $sp->code }}</td>
            <td>{{ $sp->name }}</td>
            <td>{{ $sp->category }}</td>
            <td>{{ $sp->stock }} {{ $sp->unit }}</td>
            <td>{{ $sp->batch_lot ?: '-' }}</td>
            <td>
                @if($sp->expired_at)
                    {{ \Carbon\Carbon::parse($sp->expired_at)->format('Y-m-d') }}
                @else
                    -
                @endif
            </td>
            <td>{{ $stokLabel }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="8" align="center" class="small">
                Belum ada data bahan habis pakai.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
