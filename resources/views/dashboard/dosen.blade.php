@extends('layouts.app')

@section('content')
<div class="flex bg-[#F4F6F5] min-h-screen">

    {{-- Sidebar otomatis dari layout --}}
    
    <div class="flex-1">

        {{-- TOP HEADER --}}
        <div class="bg-white border-b px-8 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-lg font-semibold text-gray-800">
                    Portal Dosen/Instruktur
                </h1>
                <p class="text-xs text-gray-500">
                    Laboratorium FKG
                </p>
            </div>

            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-emerald-200 flex items-center justify-center text-sm font-semibold text-emerald-700">
                    DS
                </div>
                <div class="text-sm">
                    <div class="font-medium text-gray-800">
                        Dr. Siti Nurhaliza
                    </div>
                    <div class="text-xs text-gray-500">
                        Dosen/Instruktur
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="p-8">

            {{-- TITLE --}}
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Portal Dosen/Instruktur
                </h2>
                <p class="text-sm text-emerald-700 mt-1">
                    Dr. Siti Nurhaliza, Sp.Perio · Instruktur Periodonsia
                </p>
            </div>

            {{-- STATISTIC CARDS --}}
            <div class="grid grid-cols-4 gap-6 mb-8">

                {{-- Kelas Aktif --}}
                <div class="bg-white rounded-xl border p-6 shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-sm text-gray-500">Kelas Aktif</p>
                        <span class="text-gray-400 text-sm">👥</span>
                    </div>
                    <h3 class="text-2xl font-bold text-emerald-700 mt-4">3</h3>
                    <p class="text-xs text-gray-400 mt-1">
                        57 total mahasiswa
                    </p>
                </div>

                {{-- Logbook Pending --}}
                <div class="bg-white rounded-xl border p-6 shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-sm text-gray-500">Logbook Pending</p>
                        <span class="text-orange-500 text-sm">🕒</span>
                    </div>
                    <h3 class="text-2xl font-bold text-orange-500 mt-4">3</h3>
                    <p class="text-xs text-gray-400 mt-1">
                        Menunggu penilaian
                    </p>
                </div>

                {{-- Dinilai Minggu Ini --}}
                <div class="bg-white rounded-xl border p-6 shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-sm text-gray-500">Dinilai Minggu Ini</p>
                        <span class="text-emerald-600 text-sm">✔</span>
                    </div>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-4">12</h3>
                    <p class="text-xs text-gray-400 mt-1">
                        Logbook selesai dinilai
                    </p>
                </div>

                {{-- Sesi Mendatang --}}
              
                <div class="bg-white rounded-xl border p-6 shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-sm text-gray-500">Sesi Mendatang</p>
                        <span class="text-gray-500 text-sm">📅</span>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mt-4">
                        {{ $stats['sesi_mendatang'] }}
                    </h3>

                    <p class="text-xs text-gray-400 mt-1">
                        7 hari ke depan
                    </p>
                </div>

            </div>

            {{-- TAB SECTION --}}
          {{-- TAB WRAPPER --}}
<div x-data="{ tab: 'logbook' }">

    {{-- TAB SECTION --}}
    <div class="bg-[#E4EFE9] rounded-full p-1 flex mb-6 text-sm font-medium">

        <button @click="tab='logbook'"
                :class="tab==='logbook' ? 'bg-white shadow text-gray-800' : 'text-gray-600'"
                class="flex-1 rounded-full py-2 transition">
            Penilaian Logbook
        </button>

        <button @click="tab='jadwal'"
                :class="tab==='jadwal' ? 'bg-white shadow text-gray-800' : 'text-gray-600'"
                class="flex-1 rounded-full py-2 transition">
            Jadwal Mengajar
        </button>

        <button @click="tab='kelas'"
                :class="tab==='kelas' ? 'bg-white shadow text-gray-800' : 'text-gray-600'"
                class="flex-1 rounded-full py-2 transition">
            Kelas Saya
        </button>

    </div>

    {{-- ===================== --}}
    {{-- LOGBOOK TAB CONTENT --}}
    {{-- ===================== --}}
    <div x-show="tab==='logbook'" x-transition>
        <div class="bg-white rounded-xl border p-6 shadow-sm">

            <div class="mb-6">
                <h3 class="font-semibold text-gray-800">
                    Logbook Menunggu Penilaian
                </h3>
                <p class="text-sm text-emerald-700">
                    Review dan beri nilai untuk logbook mahasiswa
                </p>
            </div>

            {{-- Dummy Card --}}
            <div class="border rounded-xl p-5 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-200 flex items-center justify-center text-sm font-semibold text-emerald-800">
                            SA
                        </div>
                        <div>
                            <p class="font-medium text-gray-800">
                                Siti Aminah
                            </p>
                            <p class="text-xs text-gray-500">
                                2021045 · 2025-11-05
                            </p>
                        </div>
                    </div>

                    <span class="text-xs bg-orange-100 text-orange-600 px-3 py-1 rounded-full">
                        ⏳ Pending
                    </span>
                </div>

                <button class="w-full bg-emerald-800 text-white py-2.5 rounded-lg hover:bg-emerald-900 transition">
                    Beri Penilaian
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== --}}
    {{-- JADWAL MENGAJAR TAB --}}
    {{-- ===================== --}}
    <div x-show="tab==='jadwal'" x-transition>
        <div class="bg-white rounded-xl border p-6 shadow-sm">

            <div class="mb-6">
                <h3 class="font-semibold text-gray-800">
                    Jadwal Mengajar Minggu Ini
                </h3>
                <p class="text-sm text-emerald-700">
                    Sesi praktikum dan evaluasi yang akan datang
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-gray-500 border-b">
                        <tr class="text-left">
                            <th class="py-3">Tanggal & Waktu</th>
                            <th>Kelas</th>
                            <th>Ruangan</th>
                            <th>Mahasiswa</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($jadwalMengajar as $jadwal)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="py-4">
                                <div class="font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('Y-m-d') }}
                                </div>
                                <div class="text-xs text-emerald-700">
                                    {{ $jadwal->waktu }}
                                </div>
                            </td>

                            <td class="text-gray-700">
                                {{ $jadwal->judul }}
                            </td>

                            <td class="text-gray-700">
                                {{ $jadwal->ruangan }}
                            </td>

                            <td class="text-gray-700">
                                👥 {{ $jadwal->jumlah_peserta }}
                            </td>

                            <td class="text-right">
                                <a href="#"
                                   class="text-emerald-700 font-medium hover:underline">
                                    Detail
                                </a>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-400">
                                Tidak ada jadwal minggu ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    {{-- ===================== --}}
    {{-- KELAS SAYA TAB --}}
    {{-- ===================== --}}
    <div x-show="tab==='kelas'" x-transition>
    <div class="grid grid-cols-3 gap-6">

        @forelse($jadwalMengajar as $jadwal)

        <div class="bg-white border rounded-2xl p-6 shadow-sm">

            {{-- Judul --}}
            <h3 class="font-semibold text-gray-800 mb-2">
                {{ $jadwal->judul }}
            </h3>

            {{-- Hari & Waktu --}}
            <p class="text-emerald-700 text-sm mb-6">
                {{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('l') }},
                {{ $jadwal->waktu }}
            </p>

            {{-- Ruangan --}}
            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>Ruangan</span>
                <span class="text-gray-800 font-medium">
                    {{ $jadwal->ruangan }}
                </span>
            </div>

            {{-- Mahasiswa --}}
            <div class="flex justify-between text-sm text-gray-600 mb-6">
                <span>Mahasiswa</span>
                <span class="text-gray-800 font-medium">
                    {{ $jadwal->jumlah_peserta }} orang
                </span>
            </div>

            {{-- Button 1 --}}
            <button class="w-full border rounded-lg py-2 mb-3 text-sm hover:bg-gray-50 transition">
                Lihat Daftar Mahasiswa
            </button>

            {{-- Button 2 --}}
            <button class="w-full bg-emerald-800 text-white py-2 rounded-lg text-sm hover:bg-emerald-900 transition">
                Rekap Nilai
            </button>

        </div>

        @empty
        <div class="col-span-3 text-center text-gray-400 py-10">
            Tidak ada kelas minggu ini
        </div>
        @endforelse

    </div>
</div>

</div>
        </div>
    </div>
</div>
@endsection