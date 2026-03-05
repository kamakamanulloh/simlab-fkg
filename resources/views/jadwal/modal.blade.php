<div id="modalJadwal"
    class="fixed inset-0 z-50 hidden items-start justify-center bg-black/40 backdrop-blur-sm overflow-y-auto">

    <div class="mt-8 mb-8 w-full max-w-3xl rounded-3xl bg-white shadow-2xl border border-emerald-50 max-h-[90vh] overflow-y-auto">

        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <div>
                <div class="text-sm font-semibold text-slate-900">Buat Jadwal Baru</div>
                <div class="text-xs text-slate-500 mt-1">
                    Isi formulir di bawah untuk mengajukan jadwal baru.
                </div>
            </div>
            <button type="button" id="btnCloseModalJadwal"
                    class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:bg-slate-100">
                ✕
            </button>
        </div>

        <form id="formJadwalBaru" method="POST" action="{{ route('jadwal.store') }}" class="px-6 py-5 space-y-4">
            @csrf
<input type="hidden" name="id" id="edit_id">

            {{-- Judul --}}
            <div class="space-y-1">
                <label class="text-xs font-medium text-slate-800">Judul Kegiatan</label>
                <input type="text" name="judul"
                    class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm">
            </div>
            {{-- KELAS --}}
<div class="space-y-1">
    <label class="text-xs font-medium text-slate-800">Kelas</label>

    <select name="kelas_id"
        id="kelas_id"
        class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm">

        <option value="">Pilih kelas</option>

        @foreach($kelas as $k)
            <option value="{{ $k->id }}">
                {{ $k->nama_kelas }}
            </option>
        @endforeach

    </select>
</div>

            {{-- Jenis & Ruangan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-800">Jenis</label>
                    <select name="jenis"
                        class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm">
                        <option value="">Pilih jenis</option>
                        <option value="Praktikum">Praktikum</option>
                        <option value="OSCE">OSCE</option>
                        <option value="Pelatihan">Pelatihan</option>
                        <option value="Kegiatan Lain">Kegiatan Lain</option>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-800">Ruangan</label>
                    <select name="ruangan"
                        class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm">
                        <option value="">Pilih ruangan</option>
                        <option value="Lab 1 - Ruang Praktikum Utama">Lab 1 - Ruang Praktikum Utama</option>
                        <option value="Lab 2 - Ruang OSCE">Lab 2 - Ruang OSCE</option>
                        <option value="Lab 3 - Ruang Radiologi">Lab 3 - Ruang Radiologi</option>
                        <option value="Lab 4 - Ruang Simulasi">Lab 4 - Ruang Simulasi</option>
                    </select>
                </div>
            </div>

            {{-- Tanggal & Waktu --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-800">Tanggal</label>
                    <input type="date" name="tanggal"
                        class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-slate-800">Waktu</label>
                    <input type="text" name="waktu"
                        class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm"
                        placeholder="08:00 - 11:00">
                </div>
            </div>

            {{-- Instruktur --}}
            
            <div class="space-y-1">
                <label class="text-xs font-medium text-slate-800">Instruktur / Dosen</label>
                <select name="instruktur_id" class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm" id="instruktur_id"
                    >
                    <option value="">Pilih Instruktur</option>
                    @foreach($dosen as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }} 
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Peserta --}}
            <div class="space-y-1">
                <label class="text-xs font-medium text-slate-800">Jumlah Peserta</label>
                <input type="number" name="jumlah_peserta"
                    class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm">
            </div>

            {{-- Catatan --}}
            <div class="space-y-1">
                <label class="text-xs font-medium text-slate-800">Catatan / Kebutuhan Khusus</label>
                <textarea name="catatan" rows="3"
                    class="w-full rounded-2xl border border-emerald-100 bg-emerald-50/60 px-4 py-2.5 text-sm"></textarea>
            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" id="btnCancelModalJadwal"
                    class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-xs hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit"
                    class="rounded-2xl bg-emerald-600 px-4 py-2 text-xs text-white hover:bg-emerald-700">
                    Ajukan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>


