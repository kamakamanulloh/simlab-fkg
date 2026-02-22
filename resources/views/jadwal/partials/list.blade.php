@forelse($schedules as $item)
<div
    class="group relative rounded-xl border border-emerald-100 bg-white px-4 py-3 shadow-sm
           hover:shadow-md hover:border-emerald-300 transition">

    {{-- AKSEN GARIS KIRI --}}
    <span class="absolute left-0 top-3 bottom-3 w-1 rounded-full bg-emerald-500"></span>

    <div class="flex items-start justify-between gap-4 pl-3">

        {{-- INFO --}}
        <div class="space-y-0.5">
            <div class="font-semibold text-slate-800 text-[13px]">
                {{ $item->judul }}
            </div>

            <div class="flex items-center gap-2 text-[11px] text-slate-500">
                <span>
                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                </span>
                <span class="text-slate-300">•</span>
                <span>{{ $item->waktu }}</span>
            </div>
        </div>

        {{-- MENU 3 TITIK --}}
        <div class="relative">
            <button
                class="btnMenuSchedule p-1 rounded-full text-slate-400
                       hover:bg-emerald-50 hover:text-emerald-700 transition"
                data-id="{{ $item->id }}">
                ⋮
            </button>

            <div
                class="menuSchedule hidden absolute right-0 mt-2 w-32
                       rounded-xl bg-white shadow-lg border border-slate-100
                       text-xs z-20 overflow-hidden">

                <button
                    class="btnEditSchedule w-full flex items-center gap-2
                           px-3 py-2 hover:bg-emerald-50 text-slate-700"
                    data-id="{{ $item->id }}">
                    ✏️ Edit
                </button>

                <button
                    class="btnDeleteSchedule w-full flex items-center gap-2
                           px-3 py-2 text-rose-600 hover:bg-rose-50"
                    data-id="{{ $item->id }}">
                    🗑 Hapus
                </button>
            </div>
        </div>

    </div>
</div>
@empty
<div class="text-center text-slate-500 text-xs py-6">
    Tidak ada jadwal pada tanggal ini.
</div>
@endforelse
