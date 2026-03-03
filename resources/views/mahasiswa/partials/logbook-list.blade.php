@forelse($logbooks as $log)

<div class="border border-emerald-100 rounded-2xl p-5 flex justify-between items-center hover:shadow-sm transition">

    {{-- LEFT --}}
    <div class="flex items-start gap-3">

        <div class="text-emerald-700 mt-1">
            📖
        </div>

        <div>
            {{-- Judul dari LabSchedule --}}
            <div class="font-medium text-slate-800">
                {{ $log->schedule->judul ?? '-' }}
            </div>

            {{-- Tanggal & Waktu dari LabSchedule --}}
            <div class="text-xs text-slate-500 mt-1">
                {{ \Carbon\Carbon::parse($log->schedule->session_date)->format('Y-m-d') }}
                • {{ $log->schedule->waktu }}
            </div>

            {{-- Session Code di bawah --}}
            <div class="text-xs text-slate-400 mt-1">
                {{ $log->session_code }}
            </div>
        </div>

    </div>

    {{-- RIGHT --}}
    <div class="text-right">

        @if($log->status == 'Reviewed')

            <div class="flex items-center justify-end gap-2 text-amber-500 font-semibold text-lg">
                ⭐ {{ $log->score }}
            </div>

            <div class="text-xs text-slate-500 mb-2">
                Dinilai
            </div>

            <button class="px-4 py-2 text-sm rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                Lihat Detail
            </button>

        @else

            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 inline-flex items-center gap-1">
                ⏳ Menunggu Penilaian
            </span>

        @endif

    </div>

</div>

@empty
<div class="text-center text-gray-500 py-8">
    Belum ada logbook.
</div>
@endforelse