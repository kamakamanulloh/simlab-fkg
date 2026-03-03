<aside class="w-64 bg-emerald-900 text-emerald-50 flex flex-col min-h-screen">

    <div class="px-6 py-5 border-b border-emerald-800">
        <div class="font-semibold text-sm">SIM-Lab</div>
        <div class="text-xs text-emerald-200">Lab FKG</div>
    </div>

    <nav class="flex-1 px-3 py-4 text-sm space-y-2">

        <a href="{{ route('dosen.dashboard') }}"
           class="flex items-center gap-2 px-3 py-2.5 rounded-xl
           {{ request()->routeIs('dosen.dashboard') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
            🏠 Dashboard
        </a>

        <a href="#"
           class="flex items-center gap-2 px-3 py-2.5 rounded-xl hover:bg-emerald-800/70">
            📝 Penilaian
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full text-left flex items-center gap-2 px-3 py-2.5 rounded-xl hover:bg-emerald-800/70">
                🚪 Keluar
            </button>
        </form>

    </nav>

</aside>