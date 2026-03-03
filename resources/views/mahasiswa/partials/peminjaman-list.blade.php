<div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-100">

    <h2 class="text-lg font-semibold text-slate-800 mb-1">
        Peminjaman Aktif
    </h2>
    <p class="text-sm text-emerald-700 mb-6">
        Alat yang sedang Anda pinjam
    </p>

    <div class="space-y-4">

    @forelse($loans as $loan)

        @php
            $isLate = $loan->isLate;
        @endphp

        <div class="loan-card border border-emerald-100 rounded-2xl p-5 flex justify-between items-center"
             data-loan="{{ $loan->id }}">

            {{-- LEFT CONTENT --}}
            <div>

                @foreach($loan->items as $item)

                <div class="flex items-start gap-3 mb-3">

                    <div class="text-emerald-700 mt-1">
                        👜
                    </div>

                    <div>
                        <div class="font-medium text-slate-800">
                            {{ $item->inventoryItem->name }} ({{ $item->qty }}x)
                        </div>

                        <div class="text-xs text-slate-500">
                            {{ $loan->loan_code }} • {{ $loan->purpose }}
                        </div>

                        <div class="text-xs mt-1 {{ $isLate ? 'text-red-600' : 'text-slate-500' }}">
                            ⏰ Batas: {{ $loan->due_at->format('Y-m-d H:i') }}
                        </div>
                    </div>

                </div>

                @endforeach

            </div>

            {{-- RIGHT SIDE --}}
            <div class="text-right">

                {{-- STATUS BADGE --}}
                <div class="mb-3">
                    <span class="loan-status px-3 py-1 text-xs rounded-full
                        {{ $loan->status == 'Dipinjam'
                            ? ($isLate ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-700')
                            : 'bg-emerald-100 text-emerald-700' }}">
                        {{ $loan->status }}
                    </span>
                </div>

                {{-- BUTTON --}}
                @if($loan->status == 'Dipinjam')

                    <button class="returnBtn px-4 py-2 text-sm rounded-xl border border-emerald-200 hover:bg-emerald-50 transition"
                        data-loan="{{ $loan->id }}"
                        data-loanitem="{{ $loan->items->first()->id }}"
                        data-name="{{ $loan->items->first()->inventoryItem->name }}"
                        data-qty="{{ $loan->items->first()->qty }}"
                        data-code="{{ $loan->items->first()->inventoryItem->code }}"
                        data-due="{{ $loan->due_at->format('Y-m-d H:i') }}">
                        Info Pengembalian
                    </button>

                @else

                   <button class="btn-detail-kembali px-4 py-2 text-sm rounded-xl bg-emerald-100 text-emerald-700">
    Detail Pengembalian
</button>
                @endif

            </div>

        </div>

    @empty

        <div class="text-center text-gray-500 py-8">
            Tidak ada peminjaman aktif.
        </div>

    @endforelse

    </div>

</div>