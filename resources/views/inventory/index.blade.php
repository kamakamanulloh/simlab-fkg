@extends('layouts.app')

@section('title', 'Inventori - SIM-Lab')

@section('content')
<div class="space-y-6">

    {{-- HEADER HALAMAN --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-emerald-900">Inventori Alat & Bahan</h1>
            <p class="text-sm text-emerald-700">
                Kelola peralatan dan bahan habis pakai laboratorium.
            </p>
        </div>

        <div class="flex items-center gap-3">
              <button
        id="btnOpenModalLimbah"
        type="button"
        class="inline-flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-medium text-rose-700 shadow-sm hover:bg-rose-100">
        🧪 Kategorikan Limbah
    </button>
            <a href="{{ route('inventory.export_pdf') }}"
            target="_blank"
            class="inline-flex items-center gap-2 rounded-xl border border-emerald-100 bg-white px-4 py-2 text-xs font-medium text-emerald-800 shadow-sm hover:bg-emerald-50">
                {{-- ikon download --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 12l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export PDF
            </a>


            <button
                id="btnOpenModalImport"
                type="button"
                class="inline-flex items-center gap-2 rounded-xl border border-emerald-100 bg-white px-4 py-2 text-xs font-medium text-emerald-800 shadow-sm hover:bg-emerald-50">
                {{-- ikon upload --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Import
            </button>

           <button
                id="btnOpenModalItem"
                type="button"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-medium text-white shadow-lg shadow-emerald-300/40 hover:bg-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Item
            </button>

        </div>
    </div>

    {{-- KARTU RINGKASAN ATAS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Total Alat --}}
        <div class="bg-white rounded-2xl px-5 py-4 shadow-sm border border-emerald-50">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs text-slate-500">Total Alat</div>
                <div class="text-slate-400 text-lg">🔧</div>
            </div>
            <div class="text-2xl font-semibold text-emerald-800">{{ $totalAlat }}</div>
            <div class="text-xs text-emerald-700 mt-1">{{ $alatAktif }} aktif</div>
        </div>

        {{-- Total Bahan --}}
        <div class="bg-white rounded-2xl px-5 py-4 shadow-sm border border-emerald-50">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs text-slate-500">Total Bahan</div>
                <div class="text-slate-400 text-lg">📦</div>
            </div>
            <div class="text-2xl font-semibold text-emerald-800">{{ $totalBahan }}</div>
            <div class="text-xs text-emerald-700 mt-1">{{ $bahanStokRendah }} stok rendah</div>
        </div>

        {{-- Mendekati Kedaluwarsa --}}
        <div class="bg-white rounded-2xl px-5 py-4 shadow-sm border border-emerald-50">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs text-slate-500">Mendekati Kedaluwarsa</div>
                <div class="text-amber-400 text-lg">⚠️</div>
            </div>
            <div class="text-2xl font-semibold text-amber-600">{{ $mendekatiKedaluwarsa }}</div>
            <div class="text-xs text-amber-700 mt-1">Dalam 30 hari</div>
        </div>

        {{-- Perlu Kalibrasi --}}
        <div class="bg-white rounded-2xl px-5 py-4 shadow-sm border border-emerald-50">
            <div class="flex items-center justify-between mb-2">
                <div class="text-xs text-slate-500">Perlu Kalibrasi</div>
                <div class="text-slate-400 text-lg">📅</div>
            </div>
            <div class="text-2xl font-semibold text-emerald-800">{{ $perluKalibrasi }}</div>
            <div class="text-xs text-emerald-700 mt-1">Bulan ini</div>
        </div>
    </div>

    {{-- KARTU DAFTAR INVENTORI --}}
    <div class="bg-white rounded-2xl shadow-sm border border-emerald-50">
        <div class="px-5 pt-5 pb-3 flex items-center justify-between gap-4">
            <div>
                <div class="text-sm font-semibold text-slate-800">Daftar Inventori</div>
                <div class="text-xs text-emerald-700">
                    Kelola dan pantau semua aset laboratorium
                </div>
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('inventory') }}" class="w-64">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-2 text-xs text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-500" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 7 0 000 14z"/>
                    </svg>
                    <input type="text" name="q" value="{{ $q }}"
                           placeholder="Cari item..."
                           class="w-full bg-transparent border-none focus:outline-none focus:ring-0 placeholder-slate-400">
                </div>
            </form>
        </div>

        {{-- TAB --}}
        <div class="px-5 pb-3">
            <div class="flex rounded-full bg-emerald-50/70 text-sm">
                <a href="{{ route('inventory', ['tab' => 'alat', 'q' => $q]) }}"
                   class="flex-1 text-center px-3 py-2 rounded-full
                    {{ $tab === 'alat' ? 'bg-white shadow-sm font-medium text-emerald-800' : 'text-slate-500 hover:text-emerald-700' }}">
                    Peralatan
                    @if($equipments)
                        ({{ $equipments->total() }})
                    @endif
                </a>
                <a href="{{ route('inventory', ['tab' => 'bahan', 'q' => $q]) }}"
                   class="flex-1 text-center px-3 py-2 rounded-full
                    {{ $tab === 'bahan' ? 'bg-white shadow-sm font-medium text-emerald-800' : 'text-slate-500 hover:text-emerald-700' }}">
                    Bahan Habis Pakai
                    @if($consumables)
                        ({{ $consumables->total() }})
                    @endif
                </a>
            </div>
        </div>

        {{-- ============= TAB PERALATAN ============= --}}
        @if($tab === 'alat')
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-y border-emerald-50 text-slate-500">
                            <th class="text-left px-5 py-2 font-medium">ID & Nama</th>
                            <th class="text-left px-3 py-2 font-medium">Kategori</th>
                            <th class="text-left px-3 py-2 font-medium">Lokasi</th>
                            <th class="text-left px-3 py-2 font-medium">Status</th>
                            <th class="text-left px-3 py-2 font-medium">Kalibrasi Terakhir</th>
                            <th class="text-left px-3 py-2 font-medium">Kalibrasi Berikutnya</th>
                            <th class="text-right px-5 py-2 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-50">
                        @forelse($equipments as $eq)
                            @php
                                $statusClass = match($eq->status) {
                                    'Aktif'      => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'Kalibrasi'  => 'bg-sky-50 text-sky-700 border-sky-100',
                                    'Perbaikan'  => 'bg-amber-50 text-amber-700 border-amber-100',
                                    default      => 'bg-slate-50 text-slate-600 border-slate-100',
                                };
                            @endphp
                            <tr class="hover:bg-emerald-50/40">
                                <td class="px-5 py-3 align-top">
                                    <div class="text-sm font-medium text-slate-800">{{ $eq->name }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $eq->code }}</div>
                                </td>
                                <td class="px-3 py-3 align-top">
                                    @if($eq->category)
                                        <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] text-slate-600 bg-slate-50 border-slate-200">
                                            {{ $eq->category }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 align-top text-sm font-medium text-slate-600">
                                    @if($eq->location)
                                        <span class="inline-flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M12 21s-6-5.373-6-10a6 6 0 1112 0c0 4.627-6 10-6 10z"/>
                                                <circle cx="12" cy="11" r="2.5"/>
                                            </svg>
                                            {{ $eq->location }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 align-top">
                                    @if($eq->status)
                                        <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] {{ $statusClass }}">
                                            {{ $eq->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 align-top text-sm font-medium text-slate-600">
                                    {{ $eq->last_calibration_date ? \Carbon\Carbon::parse($eq->last_calibration_date)->format('Y-m-d') : '-' }}
                                </td>
                                <td class="px-3 py-3 align-top text-sm font-medium text-slate-600">
                                    {{ $eq->next_calibration_date ? \Carbon\Carbon::parse($eq->next_calibration_date)->format('Y-m-d') : '-' }}
                                </td>
                                <td class="px-5 py-3 align-top text-right space-x-2">

                                    {{-- Tombol QR Code --}}
                                   <button
    title="QR Code"
    class="btnQrCode inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-100"
    data-id="{{ $eq->code }}"
    data-name="{{ $eq->name }}"
>
 <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 3h3v4h-3v-4zm3-3h4v3h-4v-3z"/>
                                        </svg>
                                   </button>


                                    {{-- Detail --}}
                                    <!-- <button class="inline-flex items-center text-emerald-700 text-sm hover:underline">
                                        Detail
                                    </button> -->

                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-4 text-center text-xs text-slate-500">
                                    Belum ada data peralatan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGING PERALATAN --}}
            <div class="px-5 py-3 border-t border-emerald-50">
                @if($equipments)
                    {{ $equipments->onEachSide(1)->links() }}
                @endif
            </div>
        @endif

        {{-- ============= TAB BAHAN HABIS PAKAI ============= --}}
        @if($tab === 'bahan')
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-y border-emerald-50 text-slate-500">
                            <th class="text-left px-5 py-2 font-medium">ID & Nama</th>
                            <th class="text-left px-3 py-2 font-medium">Kategori</th>
                            <th class="text-left px-3 py-2 font-medium">Stok</th>
                            <th class="text-left px-3 py-2 font-medium">Status Stok</th>
                            <th class="text-left px-3 py-2 font-medium">Batch/Lot</th>
                            <th class="text-left px-3 py-2 font-medium">Kedaluwarsa</th>
                            <th class="text-right px-5 py-2 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-50">
                        @forelse($consumables as $sp)
                            @php
                                if ($sp->stock <= 0) {
                                    $stokLabel = 'Habis';
                                    $stokClass = 'bg-rose-50 text-rose-700 border-rose-100';
                                } elseif ($sp->stock <= $sp->min_stock) {
                                    $stokLabel = 'Rendah';
                                    $stokClass = 'bg-amber-50 text-amber-700 border-amber-100';
                                } else {
                                    $stokLabel = 'Cukup';
                                    $stokClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                }

                                $percent = $sp->min_stock > 0
                                    ? min(100, intval(($sp->stock / max(1, $sp->min_stock * 2)) * 100))
                                    : 100;

                                $expSoon = $sp->expired_at && \Carbon\Carbon::parse($sp->expired_at)->isBetween(now(), now()->addDays(30));
                            @endphp

                            <tr class="hover:bg-emerald-50/40">
                                <td class="px-5 py-3 align-top">
                                    <div class="text-sm font-medium text-slate-800">{{ $sp->name }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $sp->code }}</div>
                                </td>
                                <td class="px-3 py-3 align-top">
                                    @if($sp->category)
                                        <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] text-slate-600 bg-slate-50 border-slate-200">
                                            {{ $sp->category }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 align-top text-[11px] text-slate-700">
                                    {{ $sp->stock }} {{ $sp->unit }}
                                    <div class="mt-1 w-28 h-1.5 rounded-full bg-emerald-50 overflow-hidden">
                                        <div class="h-full rounded-full bg-emerald-700" style="width: {{ $percent }}%"></div>
                                    </div>
                                </td>
                                <td class="px-3 py-3 align-top">
                                    <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-[10px] {{ $stokClass }}">
                                        {{ $stokLabel }}
                                    </span>
                                </td>
                                <td class="px-3 py-3 align-top text-sm font-medium text-slate-600">
                                    {{ $sp->batch_lot ?: '-' }}
                                </td>
                                <td class="px-3 py-3 align-top text-sm font-medium {{ $expSoon ? 'text-amber-600 font-medium' : 'text-slate-600' }}">
                                    @if($sp->expired_at)
                                        {{ \Carbon\Carbon::parse($sp->expired_at)->format('Y-m-d') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-5 py-3 align-top text-right text-[11px] text-emerald-700">
                                     <button
    title="QR Code"
    class="btnQrCode inline-flex items-center justify-center w-7 h-7 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-100"
    data-id="{{ $sp->code }}"
    data-name="{{ $sp->name }}"
>
 <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 3h7v7H3V3zm11 0h7v7h-7V3zM3 14h7v7H3v-7zm11 3h3v4h-3v-4zm3-3h4v3h-4v-3z"/>
                                        </svg>
                                   </button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-4 text-center text-xs text-slate-500">
                                    Belum ada data bahan habis pakai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGING BAHAN --}}
            <div class="px-5 py-3 border-t border-emerald-50">
                @if($consumables)
                    {{ $consumables->onEachSide(1)->links() }}
                @endif
            </div>
        @endif
    </div>
</div>
    {{-- MODAL TAMBAH ITEM BARU --}}
    <div id="modalItem"
         class="fixed inset-0 z-50 hidden items-start justify-center bg-black/40 backdrop-blur-sm overflow-y-auto">
        <div class="mt-10 mb-10 w-full max-w-3xl rounded-3xl bg-white shadow-2xl border border-emerald-50 max-h-[90vh] overflow-y-auto">
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div>
                    <div class="text-sm font-semibold text-slate-900">Tambah Item Baru</div>
                    <div class="text-xs text-slate-500 mt-1">
                        Registrasi peralatan atau bahan baru ke dalam sistem inventori.
                    </div>
                </div>
                <button type="button" id="btnCloseModalItem"
                        class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-100">
                    ✕
                </button>
            </div>

            {{-- FORM --}}
            <form id="formItemBaru" method="POST" action="{{ route('inventory.store') }}" class="px-6 py-5 space-y-4">
                @csrf

                {{-- Jenis Item --}}
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-800">Jenis Item</label>
                    <div class="relative rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm">
                        <select name="item_type" id="field_item_type"
                                class="w-full bg-transparent border-none focus:outline-none focus:ring-0 text-slate-800">
                            <option value="">Pilih jenis</option>
                            <option value="peralatan">Peralatan</option>
                            <option value="bahan">Bahan habis pakai</option>
                        </select>
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-500 text-xs">▾</span>
                    </div>
                </div>

                {{-- ID & Nama --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-slate-800">ID Item</label>
                        <input type="text" name="code"
                               class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 placeholder-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                               placeholder="EQ-008 atau SP-007">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-slate-800">Nama Item</label>
                        <input type="text" name="name"
                               class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 placeholder-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                               placeholder="Nama alat/bahan">
                    </div>
                </div>

                {{-- Kategori & Lokasi (umum) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-slate-800">Kategori</label>
                        <div class="relative rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm">
                            <select name="category"
                                    class="w-full bg-transparent border-none focus:outline-none focus:ring-0 text-slate-800">
                                <option value="">Pilih kategori</option>
                                <option value="Furniture">Furniture</option>
                                <option value="Instrument">Instrument</option>
                                <option value="Equipment">Equipment</option>
                                <option value="Material">Material</option>
                                <option value="Medicine">Medicine</option>
                                <option value="Disposable">Disposable</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-500 text-xs">▾</span>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-slate-800">Lokasi / Penyimpanan</label>
                        <input type="text" name="location"
                               class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 placeholder-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                               placeholder="Lab 1, Storage A, dll">
                    </div>
                </div>

                {{-- ============ BAGIAN PERALATAN ============ --}}
                <div id="section-peralatan" class="space-y-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-800">Status Peralatan</label>
                            <div class="relative rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm">
                                <select name="status"
                                        class="w-full bg-transparent border-none focus:outline-none focus:ring-0 text-slate-800">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Kalibrasi">Kalibrasi</option>
                                    <option value="Perbaikan">Perbaikan</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-500 text-xs">▾</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-800">Kalibrasi Terakhir</label>
                            <input type="date" name="last_calibration_date"
                                   class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-800">Kalibrasi Berikutnya</label>
                            <input type="date" name="next_calibration_date"
                                   class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                    </div>
                </div>

                {{-- ============ BAGIAN BAHAN HABIS PAKAI ============ --}}
                <div id="section-bahan" class="space-y-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-800">Stok Awal</label>
                            <input type="number" name="stock" value="0" min="0"
                                   class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-800">Satuan</label>
                            <input type="text" name="unit"
                                   class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 placeholder-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                   placeholder="box, pack, syringe, dll">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-800">Stok Minimum</label>
                            <input type="number" name="min_stock" value="0" min="0"
                                   class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-800">Batch / Lot</label>
                            <input type="text" name="batch_lot"
                                   class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 placeholder-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                   placeholder="B2024-01, dll">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-800">Tanggal Kedaluwarsa</label>
                            <input type="date" name="expired_at"
                                   class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-200">
                        </div>
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 mt-2">
                    <button type="button" id="btnCancelModalItem"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="rounded-2xl bg-emerald-600 px-4 py-2 text-xs font-medium text-white shadow-md shadow-emerald-300/60 hover:bg-emerald-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- MODAL IMPORT INVENTORI --}}
    <div id="modalImport"
         class="fixed inset-0 z-50 hidden items-start justify-center bg-black/40 backdrop-blur-sm overflow-y-auto">
        <div class="mt-10 mb-10 w-full max-w-xl rounded-3xl bg-white shadow-2xl border border-emerald-50 max-h-[90vh] overflow-y-auto">
            {{-- HEADER --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <div>
                    <div class="text-sm font-semibold text-slate-900">Import Data Inventori</div>
                    <div class="text-xs text-slate-500 mt-1">
                        Download format terlebih dahulu, isi data, lalu upload kembali ke sistem.
                    </div>
                </div>
                <button type="button" id="btnCloseModalImport"
                        class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-100">
                    ✕
                </button>
            </div>

            {{-- BODY --}}
            <div class="px-6 py-5 space-y-5">

                {{-- Download format --}}
                <div class="space-y-2">
                    <div class="text-xs font-medium text-slate-800">Download Format</div>
                    <div class="flex flex-wrap gap-3 text-xs">
                        <a href="{{ route('inventory.template', ['type' => 'peralatan']) }}"
                           class="inline-flex items-center gap-2 rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-2 text-emerald-800 hover:bg-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 12l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Format Peralatan (xls)
                        </a>

                        <a href="{{ route('inventory.template', ['type' => 'bahan']) }}"
                           class="inline-flex items-center gap-2 rounded-xl border border-sky-100 bg-sky-50 px-3 py-2 text-sky-800 hover:bg-sky-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 12l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Format Bahan Habis Pakai (xls)
                        </a>
                    </div>
                    <div class="text-[11px] text-slate-500">
                        Gunakan aplikasi spreadsheet (Excel, LibreOffice, Google Sheets) lalu simpan kembali sebagai CSV.
                    </div>
                </div>

                {{-- FORM IMPORT --}}
                <form id="formImportInventory" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-3">
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-800">Jenis Data</label>
                            <div class="relative rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm">
                                <select name="item_type_import" id="item_type_import"
                                        class="w-full bg-transparent border-none focus:outline-none focus:ring-0 text-slate-800">
                                    <option value="">Pilih jenis data</option>
                                    <option value="peralatan">Peralatan</option>
                                    <option value="bahan">Bahan habis pakai</option>
                                </select>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-emerald-500 text-xs">▾</span>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-xs font-medium text-slate-800">File Excel</label>
                            <input type="file" name="file_import" id="file_import"
                                accept=".xlsx,.xls"
                                class="block w-full text-xs text-slate-700
                                        file:mr-3 file:rounded-xl file:border-0 file:bg-emerald-600 file:px-4 file:py-2 file:text-xs file:font-medium file:text-white
                                        hover:file:bg-emerald-700">
                            <div class="text-[11px] text-slate-500">
                                Maks. 2MB. Format: Excel (.xlsx/.xls) menggunakan template yang disediakan.
                            </div>

                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 mt-4">
                        <button type="button" id="btnCancelModalImport"
                                class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-xs font-medium text-slate-600 hover:bg-slate-50">
                            Batal
                        </button>
                        <button type="submit"
                                class="rounded-2xl bg-emerald-600 px-4 py-2 text-xs font-medium text-white shadow-md shadow-emerald-300/60 hover:bg-emerald-700">
                            Upload &amp; Import
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
  {{-- ============================= --}}
{{-- MODAL KATEGORIKAN LIMBAH --}}
{{-- ============================= --}}
<div id="modalLimbah" class="modal-limbah-overlay hidden">

    <div class="modal-limbah">

        {{-- HEADER --}}
        <div class="modal-limbah-header">
            <h3>Input Data Limbah</h3>
            <button type="button" class="modal-limbah-close" id="btnCloseModalLimbah">×</button>
        </div>

        {{-- BODY --}}
        <div class="modal-limbah-body">
            <form id="formLimbah" class="space-y-4">
@csrf
                {{-- JENIS & KATEGORI --}}
                <div class="limbah-grid-2">
                    <div class="limbah-group">
                        <label>Jenis Limbah</label>
                        <select name="jenis_limbah">
                            <option value="">Pilih Jenis</option>
                            <option>B3 - Bahan Kimia</option>
                            <option>B3 - Material Infeksius</option>
                            <option>Non-B3-Umum</option>
                        </select>
                    </div>

                    <div class="limbah-group">
                        <label>Kategori</label>
                        <select name="kategori">
                            <option value="">Pilih Kategori</option>
                            <option>Benda Tajam</option>
                            <option>Infeksius</option>
                            <option>Kimia</option>
                            <option>Farmasi</option>
                            <option>Amalgam</option>
                            <option>Radio Aktif</option>
                            <option>Non Medis</option>
                            <option>Recycleable</option>
                        </select>
                    </div>
                </div>

                {{-- LOKASI & STATUS --}}
                <div class="limbah-grid-2">
                    <div class="limbah-group">
                        <label>Lokasi / Ruangan</label>
                        <input type="text" name="lokasi" placeholder="Lab 1">
                    </div>

                    <div class="limbah-group">
                        <label>Status</label>
                        <select name="status">
                            <option>Normal</option>
                            <option>Bocor</option>
                            <option>Rusak</option>
                        </select>
                    </div>
                </div>

                {{-- BERAT --}}
                <div class="limbah-group">
                    <label>Berat (gram)</label>
                    <input type="number" name="berat" min="0" step="0.01">
                </div>

                {{-- KONDISI & WADAH --}}
                <div class="limbah-section">
                    <div class="limbah-section-title">Kondisi & Wadah</div>

                    <div class="limbah-radio-group">
                        <label>
                            <input type="radio" name="kondisi_wadah" value="Layak">
                            Layak
                        </label>
                        <label>
                            <input type="radio" name="kondisi_wadah" value="Rusak">
                            Rusak
                        </label>
                    </div>
<div class="limbah-section-title">Volume Wadah</div>
                    <div class="limbah-radio-group mt-2">
                        <label>
                            <input type="radio" name="volume_wadah" value="<3/4">
                            &lt; 3/4 Penuh
                        </label>
                        <label>
                            <input type="radio" name="volume_wadah" value="Penuh">
                            Melebihi Kapasitas
                        </label>
                    </div>
                </div>

                {{-- APD --}}
                <div class="limbah-section">
                    <div class="limbah-section-title">Penggunaan APD Petugas</div>

                    <div class="limbah-radio-group">
                        <label>
                            <input type="radio" name="apd" value="Lengkap">
                            Lengkap
                        </label>
                        <label>
                            <input type="radio" name="apd" value="Tidak Lengkap">
                            Tidak Lengkap
                        </label>
                    </div>
                </div>

                {{-- KETERANGAN --}}
                <div class="limbah-group">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan" placeholder="Catatan tambahan jika ada..."></textarea>
                </div>

                {{-- STATUS VERIFIKASI --}}
                <div class="limbah-grid-2">
                    <div class="limbah-group">
                        <label>Status Verifikasi</label>
                        <select name="status_verifikasi">
                            <option>Menunggu</option>
                            <option>Terverifikasi</option>
                        </select>
                    </div>

                    <div class="limbah-group">
                        <label>Alur Pembuangan</label>
                        <select name="alur_pembuangan">
                            <option>Pihak Ke-3</option>
                            <option>Internal</option>
                        </select>
                    </div>
                </div>

            </form>
        </div>

        {{-- FOOTER --}}
        <div class="modal-limbah-footer">
            <button type="button"
                    id="btnCancelModalLimbah"
                    class="btn-limbah-cancel">
                Batal
            </button>
            <button type="submit"
                    form="formLimbah"
                    class="btn-limbah-save">
                Simpan
            </button>
        </div>

    </div>
</div>
{{-- MODAL QR CODE --}}
<div id="modalQr"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">

    <div class="w-full max-w-sm rounded-2xl bg-white shadow-xl p-6 relative">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-slate-800">
                QR Code Peralatan
            </h3>
            <button id="btnCloseQr"
                    class="text-slate-400 hover:text-slate-700 text-lg">
                ✕
            </button>
        </div>

        {{-- QR --}}
        <div class="flex justify-center mb-4">
            <div id="qrContainer" class="p-4 border rounded-xl"></div>
        </div>

        {{-- Info --}}
        <div class="text-center space-y-1">
            <div id="qrName" class="font-medium text-slate-800 text-sm"></div>
            <div id="qrId" class="text-xs text-slate-500"></div>
        </div>

        {{-- Footer --}}
        <div class="mt-5 flex justify-center">
            <button
                id="btnCloseQrBottom"
                class="px-4 py-2 rounded-lg bg-emerald-600 text-white text-xs hover:bg-emerald-700">
                Tutup
            </button>
        </div>

    </div>
</div>


@endsection


@push('scripts')
<script>
    // === MODAL LIMBAH ===
const modalLimbah = $('#modalLimbah');

$('#btnOpenModalLimbah').on('click', () => {
    modalLimbah.removeClass('hidden').addClass('flex');
});

$('#btnCloseModalLimbah, #btnCancelModalLimbah').on('click', () => {
    modalLimbah.addClass('hidden').removeClass('flex');
});

modalLimbah.on('click', function (e) {
    if (e.target === this) {
        modalLimbah.addClass('hidden').removeClass('flex');
    }
});
$(document).ready(function () {

    $('#formLimbah').on('submit', function (e) {
        e.preventDefault();

        const $form = $(this);
        const $btn  = $('.btn-limbah-save');

        $btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: "{{ route('lab-waste.store') }}",
            method: "POST",
            data: $form.serialize(),
            success: function (res) {

                $btn.prop('disabled', false).text('Simpan');

                $('#modalLimbah').addClass('hidden');
                $form[0].reset();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message,
                    confirmButtonColor: '#059669'
                });
            },
            error: function (xhr) {

                $btn.prop('disabled', false).text('Simpan');

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let msg = '';

                    Object.keys(errors).forEach(function (key) {
                        msg += errors[key][0] + '<br>';
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi gagal',
                        html: msg,
                        confirmButtonColor: '#DC2626'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan server',
                        confirmButtonColor: '#DC2626'
                    });
                }
            }
        });
    });

});
    document.addEventListener('DOMContentLoaded', function () {
        const modal    = document.getElementById('modalItem');
        const openBtn  = document.getElementById('btnOpenModalItem');
        const closeBtn = document.getElementById('btnCloseModalItem');
        const cancelBtn= document.getElementById('btnCancelModalItem');
        const form     = document.getElementById('formItemBaru');
        const selectType = document.getElementById('field_item_type');
        const sectionPeralatan = document.getElementById('section-peralatan');
        const sectionBahan      = document.getElementById('section-bahan');
           const modalImport   = document.getElementById('modalImport');
    const btnOpenImport = document.getElementById('btnOpenModalImport');
    const btnCloseImport= document.getElementById('btnCloseModalImport');
    const btnCancelImport= document.getElementById('btnCancelModalImport');
    const formImport    = document.getElementById('formImportInventory');

    function openImport() {
        modalImport.classList.remove('hidden');
        modalImport.classList.add('flex');
    }

    function closeImport() {
        modalImport.classList.add('hidden');
        modalImport.classList.remove('flex');
        if (formImport) formImport.reset();
    }

    btnOpenImport?.addEventListener('click', openImport);
    btnCloseImport?.addEventListener('click', closeImport);
    btnCancelImport?.addEventListener('click', closeImport);

    modalImport?.addEventListener('click', function (e) {
        if (e.target === modalImport) closeImport();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeImport();
    });

    // ====== SUBMIT IMPORT VIA AJAX ======
    if (formImport) {
        $('#formImportInventory').on('submit', function (e) {
            e.preventDefault();

            const $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true).text('Mengupload...');

            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('inventory.import') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    $btn.prop('disabled', false).text('Upload & Import');
                    closeImport();

                    Swal.fire({
                        icon: 'success',
                        title: 'Import berhasil',
                        text: res.message || 'Data inventori berhasil diimport.',
                        confirmButtonColor: '#059669'
                    }).then(() => {
                        window.location.reload();
                    });
                },
                error: function (xhr) {
                    $btn.prop('disabled', false).text('Upload & Import');

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON?.errors || {};
                        let messages = [];

                        Object.keys(errors).forEach(function (key) {
                            errors[key].forEach(function (msg) {
                                messages.push(msg);
                            });
                        });

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
                            text: 'Terjadi kesalahan pada server.',
                            confirmButtonColor: '#DC2626'
                        });
                    }
                }
            });
        });
    }
        function updateSections() {
            const val = selectType.value;
            sectionPeralatan.classList.toggle('hidden', val !== 'peralatan');
            sectionBahan.classList.toggle('hidden', val !== 'bahan');
        }

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            if (form) form.reset();
            updateSections();
        }

        openBtn?.addEventListener('click', openModal);
        closeBtn?.addEventListener('click', closeModal);
        cancelBtn?.addEventListener('click', closeModal);

        modal?.addEventListener('click', function (e) {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });

        selectType?.addEventListener('change', updateSections);
        updateSections();

        // ====== SIMPAN VIA AJAX + SWEETALERT ======
        if (form) {
            $('#formItemBaru').on('submit', function (e) {
                e.preventDefault();

                const $btnSubmit = $(this).find('button[type="submit"]');
                $btnSubmit.prop('disabled', true).text('Menyimpan...');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (res) {
                        $btnSubmit.prop('disabled', false).text('Simpan');
                        closeModal();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message || 'Item inventori berhasil disimpan.',
                            confirmButtonColor: '#059669'
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function (xhr) {
                        $btnSubmit.prop('disabled', false).text('Simpan');

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON?.errors || {};
                            let messages = [];

                            Object.keys(errors).forEach(function (key) {
                                errors[key].forEach(function (msg) {
                                    messages.push(msg);
                                });
                            });

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
                                text: 'Terjadi kesalahan pada server.',
                                confirmButtonColor: '#DC2626'
                            });
                        }
                    }
                });
            });
        }
    });
    document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modalQr')
    const qrContainer = document.getElementById('qrContainer')
    const qrName = document.getElementById('qrName')
    const qrId = document.getElementById('qrId')

    document.querySelectorAll('.btnQrCode').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id
            const name = btn.dataset.name

         
            qrContainer.innerHTML = ''

            new QRCode(qrContainer, {
                text: id+' - '+name,
                width: 180,
                height: 180
            })

            qrName.textContent = name
            qrId.textContent = `ID: ${id}`

            modal.classList.remove('hidden')
            modal.classList.add('flex')
        })
    })

    const closeModal = () => {
        modal.classList.add('hidden')
        modal.classList.remove('flex')
    }

    document.getElementById('btnCloseQr').onclick = closeModal
    document.getElementById('btnCloseQrBottom').onclick = closeModal

    modal.addEventListener('click', e => {
        if (e.target === modal) closeModal()
    })
})
</script>
@endpush

