<div class="bg-white rounded-2xl shadow-sm border border-emerald-50 overflow-hidden">

    {{-- HEADER --}}
    <div class="px-5 py-4 border-b border-slate-100">
        <div class="text-sm font-semibold text-slate-800">
            Daftar Jadwal
        </div>
        <div id="weekLabel" class="text-xs text-emerald-700 mt-1">
            {{ $weekRange ?? '' }}
        </div>
    </div>

    {{-- HEADER KOLOM --}}
    <div class="grid grid-cols-3 px-5 py-3 text-[11px] font-medium text-slate-500 border-b border-slate-100 bg-slate-50">
        <div>Kegiatan</div>
        <div>Ruangan</div>
        <div>Waktu</div>
    </div>

    {{-- LIST --}}
    <div class="divide-y divide-slate-100 text-xs">

        @forelse($schedules as $item)
            <div class="px-5 py-4 hover:bg-emerald-50/40 transition">

                <div class="grid grid-cols-3 gap-4 items-center">

                    {{-- KEGIATAN --}}
                    <div>
                        <div class="font-medium text-slate-800 text-[13px]">
                            {{ $item->judul }}
                        </div>

                        @php
                            $badgeColor = match($item->jenis) {
                                'Praktikum' => 'bg-blue-100 text-blue-700',
                                'OSCE' => 'bg-purple-100 text-purple-700',
                                'Pelatihan' => 'bg-emerald-100 text-emerald-700',
                                default => 'bg-slate-100 text-slate-600',
                            };
                        @endphp

                        <span class="inline-block mt-2 px-2.5 py-0.5 rounded-full text-[11px] font-medium {{ $badgeColor }}">
                            {{ $item->jenis }}
                        </span>
                    </div>

                    {{-- RUANGAN --}}
                    <div class="flex items-center gap-2 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21c-4-4-7-7-7-11a7 7 0 1114 0c0 4-3 7-7 11z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $item->ruangan }}
                    </div>

                    {{-- WAKTU --}}
                    <div class="space-y-1 text-slate-600">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </div>

                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 7v5l3 3"/>
                            </svg>
                            {{ $item->waktu }}
                        </div>
                    </div>

                </div>

            </div>
        @empty
            <div class="text-center py-8 text-slate-500">
                Tidak ada jadwal ditemukan.
            </div>
        @endforelse

    </div>

</div>