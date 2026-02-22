@php
    use Illuminate\Support\Facades\Route;

    $routeName = Route::currentRouteName();

    // mapping route → teks di header
    $headerMeta = match ($routeName) {
        'dashboard' => [
            'section'  => 'Dashboard',
            'title'    => 'Dashboard',
            'subtitle' => 'Laboratorium FKG',
        ],
        'jadwal' => [
            'section'  => 'Jadwal & Reservasi',
            'title'    => 'Jadwal & Reservasi',
            'subtitle' => 'Laboratorium FKG',
        ],
         'inventori' => [
            'section'  => 'Inventory',
            'title'    => 'Inventory',
            'subtitle' => 'Laboratorium FKG',
        ],
         'inventori' => [
            'section'  => 'Peminjaman',
            'title'    => 'Peminjaman',
            'subtitle' => 'Laboratorium FKG',
        ],
        // nanti kalau sudah ada menu lain tinggal tambah di sini
        default => [
            'section'  => 'SIM-Lab',
            'title'    => 'SIM-Lab',
            'subtitle' => 'Laboratorium FKG',
        ],
    };
@endphp

<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 md:px-10">
    <div class="flex items-center gap-3">
        <div class="hidden md:block text-xs text-slate-500 uppercase tracking-wide">
            {{ $headerMeta['section'] }}
        </div>
        <div>
            <div class="font-semibold text-sm text-slate-800">
                {{ $headerMeta['title'] }}
            </div>
            <div class="text-xs text-slate-500">
                {{ $headerMeta['subtitle'] }}
            </div>
        </div>
    </div>

    <div class="flex items-center gap-6">
        <div class="hidden md:flex items-center gap-2 text-xs text-slate-500">
            <span class="inline-flex items-center gap-1 rounded-full border px-3 py-1">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                Status: <span class="font-medium text-emerald-700">Operasional</span>
            </span>
        </div>

        @php
            $user = auth()->user();
        @endphp

        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <div class="text-sm font-semibold text-slate-800">
                    {{ $user->name ?? 'Pengguna' }}
                </div>
                <div class="text-xs text-slate-500">
                    {{ $user->role ?? '-' }}
                </div>
            </div>
            <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center text-xs font-semibold text-emerald-800">
                {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
            </div>
        </div>
    </div>
</header>
