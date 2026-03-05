@php
    $user = auth()->user();
@endphp

<aside class="w-64 bg-emerald-900 text-emerald-50 flex flex-col min-h-screen">
    {{-- Brand --}}
    <div class="px-6 py-5 flex items-center gap-3 border-b border-emerald-800">
        <div class="w-10 h-10 rounded-2xl bg-emerald-700 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.7">
                <path d="M5 20c12 0 14-9 14-15-6 0-15 2-15 14 0 .34.02.67.05 1"/>
                <path d="M9 14c1 1 2 2 3 2 2 0 3-2 3-4"/>
            </svg>
        </div>
        <div>
            <div class="font-semibold text-sm">SIM-Lab</div>
            <div class="text-xs text-emerald-200">Lab FKG</div>
        </div>
    </div>

    {{-- Menu utama --}}
    <nav class="flex-1 px-3 py-4 text-sm space-y-6 overflow-y-auto">
        <div>
            <div class="px-3 mb-2 text-xs font-semibold uppercase tracking-wide text-emerald-300">
                Menu Utama
            </div>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-2 px-3 py-2.5 rounded-xl
                              {{ request()->routeIs('dashboard') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
                        <span class="text-lg">🏠</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Jadwal & Reservasi (tidak untuk Mahasiswa?) --}}
                @if(!$user->isMahasiswa())
                    <li>
                        <a href="{{ route('jadwal') }}"
                           class="flex items-center gap-2 px-3 py-2.5 rounded-xl 
                           {{ request()->routeIs('jadwal') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
                            📅 <span>Jadwal & Reservasi</span>
                        </a>
                    </li>
                @endif

                {{-- Inventori & Peminjaman: Kepala Lab, Koordinator, Teknisi, Admin --}}
                @if($user->isKepalaLab() || $user->isKoordinator() || $user->isTeknisi() || $user->isAdmin())
                    <li>
                        <a href="{{ route('inventory') }}"
                        class="flex items-center gap-2 px-3 py-2.5 rounded-xl 
                        {{ request()->routeIs('inventory') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
                            🧪 <span>Inventori</span>
                        </a>
                    </li>

                  
                          <li>
      <a href="{{ route('peminjaman.index') }}"

           class="flex items-center gap-2 px-3 py-2.5 rounded-xl
                  {{ request()->routeIs('peminjaman.*') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
            🔁 <span>Peminjaman</span>
        </a>
    </li>
                    </li>
                @endif

                {{-- Logbook Digital: semua role --}}
                <li>
                    <a href="{{ route('logbook.index') }}"
                         class="flex items-center gap-2 px-3 py-2.5 rounded-xl
                  {{ request()->routeIs('logbook.*') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
                    📓 <span>Logbook Digital</span>
                    </a>
                </li>

                {{-- Pemeliharaan, Limbah & K3, Laporan, Quality & Audit --}}
                @if($user->isKepalaLab() || $user->isTeknisi() || $user->isAdmin() || $user->isTimMutu())
                    <li>
                        <a href="{{ route('pemeliharaan.index') }}"
                            class="flex items-center gap-2 px-3 py-2.5 rounded-xl {{ request()->routeIs('pemeliharaan.*') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
                            🛠 <span>Pemeliharaan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('limbah.index') }}"
                             class="flex items-center gap-2 px-3 py-2.5 rounded-xl {{ request()->routeIs('limbah.*') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
                            ♻️ <span>Limbah & K3</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('laporan.index') }}"
                           class="flex items-center gap-2 px-3 py-2.5 rounded-xl {{ request()->routeIs('laporan.*') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
                            📊 <span>Laporan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('quality-audit.index') }}"
                           class="flex items-center gap-2 px-3 py-2.5 rounded-xl {{ request()->routeIs('quality-audit.*') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
                            ✅ <span>Quality & Audit</span>
                        </a>
                    </li>
                @endif
                <li>
                        <a href="{{ route('kelas.index') }}"
                           class="flex items-center gap-2 px-3 py-2.5 rounded-xl {{ request()->routeIs('quality-audit.*') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
                            📊 <span>Rekapitulasi Nilai</span>
                        </a>
                    </li>
                <li>
                        <a href="{{ route('kelas.index') }}"
                           class="flex items-center gap-2 px-3 py-2.5 rounded-xl {{ request()->routeIs('quality-audit.*') ? 'bg-emerald-700 text-white' : 'hover:bg-emerald-800/70' }}">
                            ✅ <span>Manajemen Kelas & Mahasiswa</span>
                        </a>
                    </li>
            </ul>
        </div>

        {{-- Sistem --}}
        <div>
            <div class="px-3 mb-2 text-xs font-semibold uppercase tracking-wide text-emerald-300">
                Sistem
            </div>
            <ul class="space-y-1">
                @if($user->isAdmin() || $user->isKepalaLab())
                    <li>
                        <a href="#" class="flex items-center gap-2 px-3 py-2.5 rounded-xl hover:bg-emerald-800/70">
                            ⚙️ <span>Pengaturan</span>
                        </a>
                    </li>
                @endif
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full text-left flex items-center gap-2 px-3 py-2.5 rounded-xl hover:bg-emerald-800/70">
                            🚪 <span>Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</aside>
