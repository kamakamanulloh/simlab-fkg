@extends('layouts.app')

@section('title', 'Peminjaman & Pengembalian - SIM-Lab')
@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* supaya select2 tampil selaras dengan Tailwind */
        .select2-container--default .select2-selection--single {
            height: 42px;
            border-radius: 1rem;
            border-color: rgb(209 250 229); /* emerald-100 */
            background-color: rgba(240, 253, 250, 0.8); /* emerald-50/80 */
            padding: 6px 8px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
            font-size: 0.875rem;
            color: rgb(30 64 175);
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px;
        }
    </style>
@endpush

@section('content')
<div class="space-y-6">

    {{-- HEADER HALAMAN --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-emerald-900">Peminjaman & Pengembalian Alat</h1>
            <p class="text-sm text-emerald-700">
                Kelola peminjaman alat laboratorium dan tracking pengembalian.
            </p>
        </div>

        <div class="flex items-center gap-3">
           <button
                id="btnOpenLoanModal"
                type="button"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-lg shadow-emerald-300/40 hover:bg-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Peminjaman Baru
            </button>

        </div>
    </div>

    {{-- KARTU RINGKASAN ATAS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        {{-- Peminjaman Aktif --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <div class="text-sm font-medium text-slate-700">Peminjaman Aktif</div>
                <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center">
                    <span class="text-emerald-600 text-lg">🔒</span>
                </div>
            </div>
            <div>
                <div class="text-3xl font-semibold text-emerald-700">{{ $stats['aktif'] }}</div>
                <div class="text-xs text-emerald-600 mt-1">Sedang dipinjam</div>
            </div>
        </div>

        {{-- Terlambat --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <div class="text-sm font-medium text-slate-700">Terlambat</div>
                <div class="w-8 h-8 rounded-full bg-rose-50 flex items-center justify-center">
                    <span class="text-rose-500 text-lg">⚠️</span>
                </div>
            </div>
            <div>
                <div class="text-3xl font-semibold text-rose-600">{{ $stats['terlambat'] }}</div>
                <div class="text-xs text-rose-600 mt-1">Melewati batas waktu</div>
            </div>
        </div>

        {{-- Dikembalikan Hari Ini --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <div class="text-sm font-medium text-slate-700">Dikembalikan Hari Ini</div>
                <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center">
                    <span class="text-emerald-600 text-lg">✔️</span>
                </div>
            </div>
            <div>
                <div class="text-3xl font-semibold text-emerald-700">{{ $stats['dikembalikan'] }}</div>
                <div class="text-xs text-emerald-600 mt-1">{{ $stats['tanggal_return'] }}</div>
            </div>
        </div>

        {{-- Mendekati Deadline --}}
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-emerald-50 flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <div class="text-sm font-medium text-slate-700">Mendekati Deadline</div>
                <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center">
                    <span class="text-amber-500 text-lg">⏰</span>
                </div>
            </div>
            <div>
                <div class="text-3xl font-semibold text-amber-600">{{ $stats['mendekati_due'] }}</div>
                <div class="text-xs text-amber-600 mt-1">{{ $stats['deadline_info'] }}</div>
            </div>
        </div>
    </div>

    {{-- DAFTAR PEMINJAMAN (TABEL) --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50 space-y-4">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-sm font-semibold text-slate-800">Daftar Peminjaman</div>
                <div class="text-xs text-emerald-700">
                    Tracking semua transaksi peminjaman alat.
                </div>
            </div>

            <div class="w-full max-w-xs">
                <div class="flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
                    </svg>
                    <input type="text" placeholder="Cari peminjam..."
                           class="flex-1 bg-transparent border-none text-[13px] focus:outline-none focus:ring-0 placeholder-slate-400">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-[13px]">
                <thead>
                <tr class="border-y border-emerald-50 text-slate-500">
                    <th class="text-left px-5 py-2 font-medium">ID Pinjam</th>
                    <th class="text-left px-3 py-2 font-medium">Peminjam</th>
                    <th class="text-left px-3 py-2 font-medium">Alat</th>
                    <th class="text-left px-3 py-2 font-medium">Tujuan</th>
                    <th class="text-left px-3 py-2 font-medium">Waktu Pinjam</th>
                    <th class="text-left px-3 py-2 font-medium">Batas Kembali</th>
                    <th class="text-left px-3 py-2 font-medium">Status</th>
                    <th class="text-right px-5 py-2 font-medium">Aksi</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50">
                @forelse($loans as $loan)
                    @php
                        $statusClass = match($loan['status']) {
                            'Dipinjam'     => 'bg-sky-50 text-sky-700 border-sky-100',
                            'Terlambat'    => 'bg-rose-50 text-rose-700 border-rose-100',
                            'Dikembalikan' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            default        => 'bg-slate-50 text-slate-600 border-slate-100',
                        };

                        $isLate = $loan['status'] === 'Terlambat';
                    @endphp
                    <tr class="hover:bg-emerald-50/40">
                        {{-- ID --}}
                        <td class="px-5 py-3 align-top text-slate-700">
                            {{ $loan['id'] }}
                        </td>

                        {{-- PEMINJAM --}}
                        <td class="px-3 py-3 align-top">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-[11px] text-emerald-800">
                                    {{ collect(explode(' ', $loan['borrower']))->map(fn($p) => mb_substr($p,0,1))->join('') }}
                                </div>
                                <div>
                                    <div class="text-[13px] text-slate-800">{{ $loan['borrower'] }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $loan['borrower_nim'] }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- ALAT --}}
                        <td class="px-3 py-3 align-top text-[13px] text-slate-700">
                            @foreach($loan['items'] as $idx => $it)
                                <div>
                                    {{ $it['name'] }}
                                    <span class="text-slate-500">({{ $it['qty'] }}x)</span>
                                </div>
                            @endforeach
                        </td>

                        {{-- TUJUAN --}}
                        <td class="px-3 py-3 align-top text-[13px] text-slate-700">
                            {{ $loan['purpose'] }}
                        </td>

                        {{-- WAKTU PINJAM --}}
                        <td class="px-3 py-3 align-top text-[12px] text-slate-600">
                            {{ $loan['start_at'] }}
                        </td>

                        {{-- BATAS KEMBALI --}}
                        <td class="px-3 py-3 align-top text-[12px] {{ $isLate ? 'text-rose-600 font-medium' : 'text-slate-600' }}">
                            <div class="inline-flex items-center gap-1">
                                @if($isLate)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 6v6l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                                <span>{{ $loan['due_at'] }}</span>
                            </div>
                        </td>

                        {{-- STATUS --}}
                        <td class="px-3 py-3 align-top">
                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-[11px] {{ $statusClass }}">
                                {{ $loan['status'] }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td class="px-5 py-3 align-top text-right text-[12px]">
                            <div class="inline-flex items-center gap-2">
                                <button
                                    class="rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1 text-[11px] text-emerald-700 hover:bg-emerald-100">
                                    Kembalikan
                                </button>
                                <button class="text-emerald-700 hover:underline text-[11px]">
                                    Detail
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-4 text-center text-[12px] text-slate-500">
                            Belum ada data peminjaman.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGING SEDERHANA --}}
        <div class="pt-3 border-t border-emerald-50 flex items-center justify-between text-[12px] text-slate-500">
            <div>
                Menampilkan 1–{{ count($loans) }} dari {{ $totalLoans }} peminjaman
            </div>
            <div class="inline-flex items-center gap-1">
                <button class="px-2 py-1 rounded-full hover:bg-emerald-50">‹</button>
                <button class="px-3 py-1 rounded-full bg-emerald-600 text-white text-[11px]">1</button>
                <button class="px-2 py-1 rounded-full hover:bg-emerald-50">›</button>
            </div>
        </div>
    </div>

    {{-- ALAT TERSEDIA UNTUK DIPINJAM --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-emerald-50 space-y-3">
        <div>
            <div class="text-sm font-semibold text-slate-800">Alat Tersedia untuk Dipinjam</div>
            <div class="text-xs text-emerald-700">
                Daftar alat yang ready dan dapat dipinjam saat ini.
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="flex gap-4 pb-2 min-w-full">
                @forelse($availableEquipments as $item)
                    <div class="min-w-[190px] max-w-[210px] bg-white border border-emerald-50 rounded-2xl shadow-sm px-4 py-4 flex flex-col justify-between">
                        <div class="mb-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6 7h12l-1 11H7L6 7zM9 7V5a3 3 0 016 0v2"/>
                                </svg>
                            </div>
                            <div class="text-[13px] font-medium text-slate-800">
                                {{ $item['name'] }}
                            </div>
                            <div class="text-[11px] text-emerald-700">
                                {{ $item['code'] }}
                            </div>
                        </div>
                        <div>
                            <span class="inline-flex items-center rounded-full border border-emerald-100 bg-emerald-50 px-3 py-1 text-[11px] text-emerald-700">
                                {{ $item['stock'] }} unit
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-[12px] text-slate-500">
                        Tidak ada alat yang tersedia saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
{{-- MODAL FORMULIR PEMINJAMAN --}}
<div id="modalLoan"
     class="fixed inset-0 z-50 hidden items-start justify-center bg-black/40 backdrop-blur-sm overflow-y-auto">
    <div class="mt-8 mb-8 w-full max-w-3xl rounded-3xl bg-white shadow-2xl border border-emerald-50 max-h-[90vh] overflow-y-auto">

        {{-- HEADER MODAL --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <div class="text-sm font-semibold text-slate-900">Formulir Peminjaman Alat</div>
                <div class="text-xs text-slate-500 mt-1">
                    Lengkapi data peminjaman. Scan QR code untuk verifikasi alat.
                </div>
            </div>
            <button type="button" id="btnCloseLoanModal"
                    class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-100">
                ✕
            </button>
        </div>

        {{-- BODY MODAL --}}
        <form id="formLoan" method="POST" action="{{ route('peminjaman.store') }}" class="px-6 py-5 space-y-4">
            @csrf

            {{-- NAMA PEMINJAM & NIM/NIP --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-800">Nama Peminjam</label>
                    <select id="borrowerSelect"
                            name="borrower_id"
                            class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 focus:outline-none">
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-800">NIM / NIP</label>
                    <input type="text"
                        id="borrowerNip"
                        name="borrower_nip"
                        readonly
                        class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 focus:outline-none">
                </div>
            </div>


            {{-- Tujuan --}}
            <div class="space-y-1">
                <label class="text-xs font-medium text-slate-800">Tujuan Peminjaman</label>
                <input type="text" name="purpose"
                       class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 placeholder-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                       placeholder="contoh: Praktikum Endodontik">
            </div>

            {{-- PILIH ALAT --}}
            <div class="space-y-2">
                <div class="text-xs font-medium text-slate-800">Pilih Alat</div>
                <div class="rounded-2xl border border-slate-100 bg-slate-50/40 px-4 py-3 space-y-2">
                    @forelse($availableEquipments as $inv)
                        <div class="flex items-center justify-between py-2 border-b last:border-b-0 border-slate-100">
                            <div>
                                <div class="text-sm font-medium text-slate-800">{{ $inv['name'] }}</div>
                                <div class="text-[11px] text-slate-500">{{ $inv['code'] }}</div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100 px-3 py-1 text-[11px]">
                                   {{ $inv['stock'] }} tersedia
                                </span>
                                <div class="flex items-center gap-1">
                                    <input type="number"
                                            name="items[{{ $inv['id'] }}]"
                                            min="0"
                                            max="{{ $inv['stock'] }}"
                                            value="0"
                                           class="w-16 rounded-xl border border-emerald-100 bg-emerald-50/60 px-2 py-1 text-sm text-center focus:outline-none focus:ring-2 focus:ring-emerald-200">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-xs text-slate-500">
                            Belum ada alat yang tersedia untuk dipinjam.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Tanggal & Batas Pengembalian --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-800">Tanggal & Waktu Pinjam</label>
                    <input type="datetime-local" name="start_at"
                           class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-800">Batas Pengembalian</label>
                    <input type="datetime-local" name="due_at"
                           class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                </div>
            </div>
{{-- KONDISI ALAT AWAL (FOTO & QR) --}}
<div class="space-y-2">
    <label class="text-xs font-medium text-slate-800">
        Kondisi Alat Awal (Foto / Scan QR)
    </label>

    <div class="flex flex-wrap gap-3 items-center">
        {{-- tombol ambil foto --}}
        <button type="button"
                id="btnAmbilFoto"
                class="inline-flex items-center gap-2 rounded-2xl border border-emerald-100 bg-white px-4 py-2 text-xs font-medium text-emerald-700 hover:bg-emerald-50">
            📷 <span>Ambil Foto</span>
        </button>

        {{-- tombol scan qr --}}
        <button type="button"
                id="btnScanQr"
                class="inline-flex items-center gap-2 rounded-2xl border border-emerald-100 bg-white px-4 py-2 text-xs font-medium text-emerald-700 hover:bg-emerald-50">
            🔍 <span>Scan QR</span>
        </button>

        {{-- hidden field hasil QR --}}
        <input type="hidden" id="qrResult" name="qr_result">

        {{-- preview area (photo) --}}
        <div id="photoPreviewWrapper" class="hidden flex-col items-start gap-2">
            <div class="text-xs text-slate-600">Preview Foto:</div>
            <img id="photoPreview" src="" alt="Preview Foto" class="w-40 h-28 object-cover rounded-md border">
            <div class="flex gap-2">
                <button type="button" id="btnRetakePhoto" class="rounded-2xl border px-3 py-1 text-xs">Ambil Ulang</button>
                <button type="button" id="btnRemovePhoto" class="rounded-2xl border px-3 py-1 text-xs">Hapus</button>
            </div>
        </div>
    </div>

    {{-- kamera modal ringan (overlay) untuk foto & qr (shared) --}}
    <div id="cameraOverlay" class="fixed inset-0 z-60 hidden items-center justify-center bg-black/60">
        <div class="bg-white rounded-2xl max-w-xl w-full p-4">
            <div class="flex items-center justify-between mb-3">
                <div class="text-sm font-medium">Kamera</div>
                <button id="btnCloseCamera" class="text-sm px-2 py-1">✕</button>
            </div>

            <div id="cameraArea" class="relative">
                <!-- video stream -->
                <video id="cameraVideo" autoplay playsinline class="w-full rounded-md bg-black"></video>

                <!-- area QR scanner overlay (optional) -->
                <div id="qrOverlay" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-48 h-32 border-2 border-dashed border-white/70 rounded"></div>
                </div>
            </div>

            <div class="mt-3 flex items-center justify-between">
                <div id="cameraMsg" class="text-xs text-slate-600">Mode: <span id="cameraModeText">—</span></div>
                <div class="flex gap-2">
                    <button id="btnCapturePhoto" type="button" class="rounded-2xl bg-emerald-600 text-white px-4 py-2 text-sm hidden">
                        Potret
                    </button>
                    <button id="btnStartScan" type="button" class="rounded-2xl bg-emerald-600 text-white px-4 py-2 text-sm hidden">
                        Mulai Scan
                    </button>
                    <button id="btnStopScan" type="button" class="rounded-2xl bg-rose-600 text-white px-4 py-2 text-sm hidden">
                        Berhenti
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- hidden file input utk menerima blob (opsional) --
         kita tidak perlu menggunakannya; FormData akan dikirim langsung --}}
</div>


            {{-- FOOTER MODAL --}}
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 mt-2">
                <button type="button" id="btnCancelLoan"
                        class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit"
                        class="rounded-2xl bg-emerald-600 px-4 py-2 text-xs font-medium text-white shadow-md shadow-emerald-300/60 hover:bg-emerald-700">
                    Simpan Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
  <script>
        $(document).ready(function () {
           console.log('tes');
             console.log('Select2 Ready');

  $('#borrowerSelect').select2({
    placeholder: 'Pilih peminjam',
    allowClear: true,
    width: '100%',
    dropdownParent: $('#modalLoan'),    // <-- PENTING untuk modal
    ajax: {
        url: '{{ route('borrowers.search') }}',
        dataType: 'json',
        delay: 250,
        data: function (params) { return { q: params.term }; },
        processResults: function (data) { return { results: data.results }; }
    }
});


    // ketika dipilih -> autopopulate NIP
    $('#borrowerSelect').on('select2:select', function (e) {
        let data = e.params.data;
        $('#borrowerNip').val(data.nip ?? '');
    });

    $('#borrowerSelect').on('select2:clear', function () {
        $('#borrowerNip').val('');
    });
           
        });
  
    
    document.addEventListener('DOMContentLoaded', function () {
        const $modal   = $('#modalLoan');
        const $form    = $('#formLoan');
        const $body    = $('body');

            const btnAmbilFoto = document.getElementById('btnAmbilFoto');
    const btnScanQr    = document.getElementById('btnScanQr');
    const cameraOverlay = document.getElementById('cameraOverlay');
    const cameraVideo  = document.getElementById('cameraVideo');
    const btnCloseCamera = document.getElementById('btnCloseCamera');
    const btnCapturePhoto = document.getElementById('btnCapturePhoto');
    const btnStartScan = document.getElementById('btnStartScan');
    const btnStopScan = document.getElementById('btnStopScan');
    const cameraModeText = document.getElementById('cameraModeText');
    const qrResultInput = document.getElementById('qrResult');

    const photoPreviewWrapper = document.getElementById('photoPreviewWrapper');
    const photoPreview = document.getElementById('photoPreview');
    const btnRetakePhoto = document.getElementById('btnRetakePhoto');
    const btnRemovePhoto = document.getElementById('btnRemovePhoto');

    let currentStream = null;
    let html5QrcodeScanner = null;
    let currentMode = null; // 'photo' or 'qr'
    let capturedPhotoBlob = null;

    // utility: start camera (prefer rear)
    async function startCamera() {
        stopCamera(); // ensure stop first
        try {
            currentStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: { ideal: "environment" } },
                audio: false
            });
            cameraVideo.srcObject = currentStream;
            await cameraVideo.play();
            return true;
        } catch (err) {
            console.error('Gagal membuka kamera:', err);
            alert('Gagal membuka kamera. Pastikan izin kamera diberikan dan perangkat mendukung.');
            return false;
        }
    }

    function stopCamera() {
        if (currentStream) {
            currentStream.getTracks().forEach(t => t.stop());
            currentStream = null;
        }
        // stop html5-qrcode if active
        if (html5QrcodeScanner) {
            try { html5QrcodeScanner.clear(); } catch(e){/*ignore*/ }
            html5QrcodeScanner = null;
        }
        cameraVideo.pause();
        cameraVideo.srcObject = null;
    }

    function openCameraOverlay(mode) {
        currentMode = mode;
        cameraOverlay.classList.remove('hidden');
        // show/hide controls
        if (mode === 'photo') {
            btnCapturePhoto.classList.remove('hidden');
            btnStartScan.classList.add('hidden');
            btnStopScan.classList.add('hidden');
            cameraModeText.textContent = 'Foto';
        } else {
            btnCapturePhoto.classList.add('hidden');
            btnStartScan.classList.remove('hidden');
            btnStopScan.classList.add('hidden');
            cameraModeText.textContent = 'Scan QR';
        }

        startCamera().then(ok => {
            if (!ok) {
                closeCameraOverlay();
            }
        });
    }

    function closeCameraOverlay() {
        stopCamera();
        cameraOverlay.classList.add('hidden');
        currentMode = null;
    }

    btnCloseCamera.addEventListener('click', function () {
        closeCameraOverlay();
    });

    // Ambil Foto flow
    btnAmbilFoto.addEventListener('click', function () {
        openCameraOverlay('photo');
    });

    btnCapturePhoto.addEventListener('click', function () {
        if (!currentStream) return;

        // capture current frame
        const video = cameraVideo;
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth || 1280;
        canvas.height = video.videoHeight || 720;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        canvas.toBlob(function (blob) {
            if (!blob) {
                alert('Gagal mengambil foto.');
                return;
            }
            capturedPhotoBlob = blob;

            // preview
            const url = URL.createObjectURL(blob);
            photoPreview.src = url;
            photoPreviewWrapper.classList.remove('hidden');

            // tutup kamera overlay
            closeCameraOverlay();
        }, 'image/jpeg', 0.9);
    });

    btnRetakePhoto.addEventListener('click', function () {
        // clear preview and reopen camera
        if (photoPreview.src) {
            URL.revokeObjectURL(photoPreview.src);
        }
        photoPreview.src = '';
        photoPreviewWrapper.classList.add('hidden');
        capturedPhotoBlob = null;
        openCameraOverlay('photo');
    });

    btnRemovePhoto.addEventListener('click', function () {
        if (photoPreview.src) {
            URL.revokeObjectURL(photoPreview.src);
        }
        photoPreview.src = '';
        photoPreviewWrapper.classList.add('hidden');
        capturedPhotoBlob = null;
    });

    // QR scan flow using html5-qrcode library
    btnScanQr.addEventListener('click', function () {
        openCameraOverlay('qr');
        // initialize html5-qrcode with video element id
        const qrRegionId = 'cameraArea';
        // ensure html5-qrcode attached to that container
        // We will create scanner instance bound to cameraVideo element via Html5Qrcode
        // But simpler: use Html5QrcodeScanner with default UI in a small area.
        // However we already use video element; html5-qrcode supports using a provided element id for scanning via camera.
        // We'll create scanner and start camera scanning.

        // hide default video (we already have) — instead use Html5Qrcode to manage; for reliability, we'll use Html5Qrcode with a temp div
        // create container
        let tempDiv = document.createElement('div');
        tempDiv.id = 'html5qr-temp';
        tempDiv.style.width = '100%';
        tempDiv.style.minHeight = '240px';
        const cameraArea = document.getElementById('cameraArea');
        cameraArea.innerHTML = ''; // clear, we'll add scanner UI
        cameraArea.appendChild(tempDiv);

        html5QrcodeScanner = new Html5Qrcode(/* element id */ "html5qr-temp", /* verbose= */ false);
        const config = { fps: 10, qrbox: { width: 250, height: 150 }, experimentalFeatures: { useBarCodeDetectorIfSupported: true } };

        btnStartScan.classList.add('hidden');
        btnStopScan.classList.remove('hidden');

        html5QrcodeScanner.start(
            { facingMode: "environment" },
            config,
            qrMessage => {
                // qrMessage is the decoded string
                console.log("QR scanned:", qrMessage);
                qrResultInput.value = qrMessage;
                Swal.fire({
                    icon: 'success',
                    title: 'QR Terdeteksi',
                    text: qrMessage,
                    confirmButtonColor: '#059669'
                });
                // stop scanning and close
                html5QrcodeScanner.stop().then(() => {
                    html5QrcodeScanner.clear();
                    html5QrcodeScanner = null;
                    closeCameraOverlay();
                }).catch(()=> {
                    closeCameraOverlay();
                });
            },
            errorMessage => {
                // optional per-frame error
                // console.debug("QR scan error", errorMessage);
            }
        ).catch(err => {
            console.error('Gagal memulai QR scanner', err);
            alert('Gagal memulai QR scanner. Pastikan izin kamera diberikan.');
            closeCameraOverlay();
        });
    });

    // stop button
    btnStopScan.addEventListener('click', function () {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.stop().then(() => {
                html5QrcodeScanner.clear();
                html5QrcodeScanner = null;
                closeCameraOverlay();
            }).catch(err => {
                closeCameraOverlay();
            });
        } else {
            closeCameraOverlay();
        }
    });

    // When closing overlay, ensure scanner cleared
    cameraOverlay.addEventListener('click', function (e) {
        if (e.target === cameraOverlay) {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(()=> html5QrcodeScanner.clear()).catch(()=>{});
                html5QrcodeScanner = null;
            }
            closeCameraOverlay();
        }
    });

    // ---- Form submission: use FormData to include photo blob and qr_result ----
    const form = document.getElementById('formLoan');
    form.addEventListener('submit', function (ev) {
        ev.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Menyimpan...';

        // build FormData
        const fd = new FormData(form); // includes all form fields
        // append captured photo if exists
        if (capturedPhotoBlob) {
            fd.append('condition_photo', capturedPhotoBlob, 'condition.jpg');
        }

        // Send via AJAX
        $.ajax({
            url: form.action,
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (res) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Simpan Peminjaman';
                // close modal (existing function in your script)
                if (typeof closeModal === 'function') closeModal();
                else { $('#modalLoan').addClass('hidden').removeClass('flex'); }

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message || 'Peminjaman berhasil dibuat.',
                    confirmButtonColor: '#059669'
                }).then(() => location.reload());
            },
            error: function (xhr) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Simpan Peminjaman';
                let msg = 'Terjadi kesalahan pada server.';
                if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                if (xhr.status === 422 && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    msg = Object.values(errors).flat().join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    html: msg,
                    confirmButtonColor: '#DC2626'
                });
            }
        });
    });

    // CLEANUP when leaving page
    window.addEventListener('beforeunload', function () {
        stopCamera();
    });

        function openModal() {
            $modal.removeClass('hidden').addClass('flex');
            $body.addClass('overflow-hidden');
        }

        function closeModal() {
            $modal.addClass('hidden').removeClass('flex');
            $body.removeClass('overflow-hidden');
            if ($form.length) {
                $form[0].reset();
            }
        }

        $('#btnOpenLoanModal').on('click', openModal);
        $('#btnCloseLoanModal, #btnCancelLoan').on('click', closeModal);

        $modal.on('click', function (e) {
            if (e.target === this) {
                closeModal();
            }
        });

        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // ==== SUBMIT VIA AJAX ====
        $('#formLoan').on('submit', function (e) {
    e.preventDefault();

    const $form = $(this);
    const $btn = $form.find('button[type="submit"]');
    $btn.prop('disabled', true).text('Menyimpan...');

    const fd = new FormData(this); // ambil semua input (borrower_id, borrower_nip, purpose, start_at, due_at, items[], qr_result)
    // append foto jika ada (dari kamera)
    if (typeof capturedPhotoBlob !== 'undefined' && capturedPhotoBlob) {
        fd.append('condition_photo', capturedPhotoBlob, 'condition.jpg');
    }

    $.ajax({
        url: $form.attr('action'),
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        success: function (res) {
            $btn.prop('disabled', false).text('Simpan Peminjaman');
            // close modal
            $('#modalLoan').addClass('hidden').removeClass('flex');
            $('body').removeClass('overflow-hidden');

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message || 'Peminjaman berhasil dibuat.',
                confirmButtonColor: '#059669'
            }).then(() => {
                window.location.reload();
            });
        },
        error: function (xhr) {
            $btn.prop('disabled', false).text('Simpan Peminjaman');

            if (xhr.status === 422) {
                const errors = xhr.responseJSON?.errors || {};
                let messages = [];
                Object.keys(errors).forEach(function (k) {
                    errors[k].forEach(msg => messages.push(msg));
                });
                if (xhr.responseJSON?.message && messages.length === 0) {
                    messages.push(xhr.responseJSON.message);
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi gagal',
                    html: messages.join('<br>'),
                    confirmButtonColor: '#DC2626'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan pada server.',
                    confirmButtonColor: '#DC2626'
                });
            }
        }
    });
});
    });
</script>
@endpush
