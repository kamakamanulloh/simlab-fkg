@extends('layouts.app')

@section('content')
<div class="flex bg-[#F4F6F5] min-h-screen">

 

    <div class="flex-1 p-8">
{{-- HEADER --}}
<div class="flex justify-between items-start mb-8">

    <div>
        <h1 class="text-2xl font-semibold text-gray-800">
            Portal Mahasiswa
        </h1>

        <div class="text-sm text-gray-600 mt-1">
            {{ auth()->user()->name }}
            • NIM: {{ auth()->user()->username ?? auth()->user()->nim }}
         
        </div>
    </div>

    {{-- Badge Progress --}}
    <div class="bg-white px-4 py-2 rounded-xl shadow-sm border text-sm font-medium text-gray-700">
        {{ $overallProgress ?? 80 }}% Progress
    </div>

</div>

        {{-- MENU ATAS --}}
        <div class="grid grid-cols-3 gap-6 mb-8">

   
 <div id="openReservation"
     class="bg-white rounded-2xl p-6 shadow-sm text-center cursor-pointer hover:shadow-md transition">
                📅
                <div class="mt-3 text-sm font-medium">Reservasi Ruang/Waktu</div>
            </div>

            <div id="openLoan"
     class="bg-white rounded-2xl p-6 shadow-sm text-center cursor-pointer hover:shadow-md transition">
                📦
                <div class="mt-3 text-sm font-medium">Pinjam Alat</div>
            </div>

          <div id="openLogbook"
     class="bg-white rounded-2xl p-6 shadow-sm text-center cursor-pointer hover:shadow-md transition">
    📘
    <div class="mt-3 text-sm font-medium">Isi Logbook</div>
</div>
        </div>

        {{-- TAB SECTION --}}
        <div x-data="{ tab: 'jadwal' }">

            <div class="bg-[#E4EFE9] rounded-full p-1 flex mb-6 text-sm font-medium">
                <button @click="tab='jadwal'"
                        :class="tab==='jadwal' ? 'bg-white shadow text-gray-800' : 'text-gray-600'"
                        class="flex-1 rounded-full py-2">
                    Jadwal Saya
                </button>

                <button @click="tab='peminjaman'"
                        :class="tab==='peminjaman' ? 'bg-white shadow text-gray-800' : 'text-gray-600'"
                        class="flex-1 rounded-full py-2">
                    Peminjaman Saya
                </button>

                    <button @click="tab='logbook'"
                        :class="tab==='logbook' ? 'bg-white shadow text-gray-800' : 'text-gray-600'"
                        class="flex-1 rounded-full py-2">
                    Logbook Saya
                </button>

                <button @click="tab='progress'"
                        :class="tab==='progress' ? 'bg-white shadow text-gray-800' : 'text-gray-600'"
                        class="flex-1 rounded-full py-2">
                    Progress
                </button>
            </div>

            {{-- =================== --}}
            {{-- TAB JADWAL --}}
            {{-- =================== --}}
            <div x-show="tab==='jadwal'" class="grid grid-cols-2 gap-6">

                {{-- KALENDER --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm">
                    <div id="calendarTitle" class="text-sm font-medium mb-4"></div>
                    <div id="calendarGrid" class="grid grid-cols-7 gap-2 text-xs"></div>
                </div>

                {{-- LIST JADWAL --}}
                <div id="scheduleList" class="bg-white rounded-2xl p-5 shadow-sm">
                    Pilih tanggal untuk melihat jadwal
                </div>

            </div>
            <div x-show="tab==='peminjaman'" class="space-y-4">
    <div id="loanListContainer">
        Memuat data...
    </div>
</div>
<div x-show="tab==='logbook'" class="space-y-6">

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-100">

        <h2 class="text-lg font-semibold text-slate-800 mb-1">
            Riwayat Logbook
        </h2>

        <p class="text-sm text-emerald-700 mb-6">
            Entri logbook dan penilaian
        </p>

        <div id="logbookList" class="space-y-4">

            {{-- DATA DARI DB AWAL --}}
            @foreach($logbooks ?? [] as $log)
                <div class="border rounded-2xl p-4 flex justify-between items-center">

                    <div>
                        <div class="font-medium">{{ $log->session_name }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $log->session_code }} • {{ $log->session_date->format('Y-m-d') }}
                        </div>
                    </div>

                    <div>
                        @if($log->status == 'Reviewed')
                            <div class="flex items-center gap-2 text-amber-500 font-semibold">
                                ⭐ {{ $log->score }}
                            </div>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                Menunggu Penilaian
                            </span>
                        @endif
                    </div>

                </div>
            @endforeach

        </div>

    </div>

</div>
            {{-- =================== --}}
            {{-- TAB PROGRESS --}}
            {{-- =================== --}}
            <div x-show="tab==='progress'" class="space-y-6">

                @foreach($progress as $item)
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex justify-between">
                        <div>
                            <div class="font-medium">{{ $item['nama'] }}</div>
                            <div class="text-xs text-gray-500">
                                {{ $item['done'] }}/{{ $item['total'] }} kompetensi
                            </div>
                        </div>
                        <div class="text-emerald-700 font-bold text-lg">
                            ⭐ {{ $item['avg'] }}
                        </div>
                    </div>

                    <div class="w-full h-2 bg-emerald-100 rounded-full mt-4">
                        <div class="h-full bg-emerald-700 rounded-full"
                             style="width: {{ ($item['done']/$item['total'])*100 }}%">
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>

    </div>
</div>
{{-- MODAL RESERVASI --}}
<div id="reservationModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg rounded-2xl p-6 relative">

        <button id="closeModal" class="absolute right-4 top-4 text-gray-400">✕</button>

        <h2 class="text-lg font-semibold text-gray-800">
            Reservasi Ruang Praktikum
        </h2>
        <p class="text-sm text-emerald-700 mt-1 mb-6">
            Ajukan reservasi untuk praktikum mandiri atau kelompok
        </p>

        <form id="reservationForm" class="space-y-4">

            @csrf

            <div>
                <label class="text-sm font-medium">Tujuan Reservasi</label>
                <input type="text" name="tujuan"
                       placeholder="contoh: Praktikum mandiri preparasi gigi"
                       class="w-full mt-2 rounded-xl bg-emerald-50 border-0 px-4 py-3 text-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Tanggal</label>
                    <input type="date" name="tanggal"
                           class="w-full mt-2 rounded-xl bg-emerald-50 border-0 px-4 py-3 text-sm">
                </div>

                <div>
                    <label class="text-sm font-medium">Waktu</label>
                    <input type="text" name="waktu"
                           placeholder="14:00 - 16:00"
                           class="w-full mt-2 rounded-xl bg-emerald-50 border-0 px-4 py-3 text-sm">
                </div>
            </div>

            <div>
                <label class="text-sm font-medium">Jumlah Peserta</label>
                <input type="number" name="jumlah_peserta" value="1"
                       class="w-full mt-2 rounded-xl bg-emerald-50 border-0 px-4 py-3 text-sm">
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" id="cancelBtn"
                        class="px-4 py-2 rounded-xl border text-gray-600">
                    Batal
                </button>

                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-emerald-700 text-white">
                    Ajukan Reservasi
                </button>
            </div>

        </form>
    </div>
</div>
{{-- MODAL PEMINJAMAN --}}
<div id="loanModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg rounded-2xl p-6 relative">

        <button id="closeLoanModal" class="absolute right-4 top-4 text-gray-400">✕</button>

        <h2 class="text-lg font-semibold text-gray-800">
            Ajukan Peminjaman Alat
        </h2>
        <p class="text-sm text-emerald-700 mt-1 mb-6">
            Pilih alat yang ingin dipinjam untuk praktikum
        </p>

        <form id="loanForm" class="space-y-4">
            @csrf

            <div>
                <label class="text-sm font-medium">Tujuan Peminjaman</label>
                <input type="text" name="purpose"
                       placeholder="contoh: Praktikum Endodontik"
                       class="w-full mt-2 rounded-xl bg-emerald-50 border-0 px-4 py-3 text-sm">
            </div>

            <div>
                <label class="text-sm font-medium">Pilih Alat</label>
                <select id="alatSelect" name="lab_inventory_item_id"
                        class="w-full mt-2 rounded-xl bg-emerald-50 border-0 px-4 py-3 text-sm">
                    <option value="">Pilih alat</option>
                    @foreach($alatList as $alat)
                        <option value="{{ $alat->id }}">
                            {{ $alat->name }} (Stok: {{ $alat->stock }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium">Jumlah</label>
                    <input type="number" name="qty" value="1"
                           class="w-full mt-2 rounded-xl bg-emerald-50 border-0 px-4 py-3 text-sm">
                </div>

                <div>
                    <label class="text-sm font-medium">Durasi (jam)</label>
                    <input type="number" name="duration" value="4"
                           class="w-full mt-2 rounded-xl bg-emerald-50 border-0 px-4 py-3 text-sm">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" id="cancelLoanBtn"
                        class="px-4 py-2 rounded-xl border text-gray-600">
                    Batal
                </button>

                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-emerald-700 text-white">
                    Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL PENGEMBALIAN --}}
<div id="returnModal"
     class="fixed inset-0 z-[9999] hidden">

    {{-- OVERLAY + CENTER WRAPPER --}}
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

    <div class="fixed inset-0 flex items-center justify-center p-4">

        {{-- MODAL BOX --}}
        <div class="bg-white w-full max-w-xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl relative p-6">

            {{-- CLOSE --}}
            <button id="closeReturnModal"
                    class="absolute right-5 top-5 text-gray-400 hover:text-gray-600 text-lg">
                ✕
            </button>

            {{-- HEADER --}}
            <h2 id="returnTitle"
                class="text-lg font-semibold text-gray-800">
                Pengembalian Alat
            </h2>

            <p class="text-sm text-emerald-700 mt-1 mb-6">
                Verifikasi kondisi alat sebelum menyelesaikan pengembalian
            </p>

            <form id="returnForm" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <input type="hidden" name="loan_id" id="returnLoanId">
                <input type="hidden" name="loan_item_id" id="returnLoanItemId">

                {{-- CARD --}}
                <div class="border border-emerald-100 rounded-2xl p-4 flex justify-between items-center">
                    <div>
                        <div id="returnItemName" class="font-medium text-gray-800">
                            Handpiece NSK (2x)
                        </div>
                        <div id="returnItemCode" class="text-xs text-emerald-600 mt-1">
                            ID: EQ-006
                        </div>
                    </div>

                    <select name="condition"
                            class="bg-emerald-50 rounded-xl px-4 py-2 text-sm border-0 focus:ring-emerald-500">
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>

                {{-- BATAS --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Batas Waktu
                    </label>

                    <div class="mt-2 bg-emerald-50 rounded-xl px-4 py-3 text-sm flex items-center gap-2">
                        ⏰
                        <span id="returnDueDate">
                            Batas: 2025-11-05 16:00
                        </span>
                    </div>
                </div>

                {{-- LOKASI --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Lokasi
                    </label>

                    <div class="mt-2 bg-emerald-50 rounded-xl px-4 py-3 text-sm">
                        Laboratorium FKG
                    </div>
                </div>

                {{-- CATATAN --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Catatan (Opsional)
                    </label>

                    <textarea name="note"
                              class="w-full mt-2 bg-emerald-50 rounded-xl border-0 px-4 py-3 text-sm focus:ring-emerald-500"
                              placeholder="Ada kerusakan atau catatan khusus..."></textarea>
                </div>

                {{-- FOTO --}}
                <div>
                    <label class="text-sm font-medium text-gray-700">
                        Foto Kondisi Akhir (Opsional)
                    </label>

                    <div class="mt-2 border border-dashed border-emerald-200 rounded-xl p-5 text-center relative cursor-pointer hover:bg-emerald-50 transition">

                        <input type="file"
                               name="photo"
                               id="returnPhotoInput"
                               class="absolute inset-0 opacity-0 cursor-pointer">

                        <div id="photoPreviewArea">
                            📷
                            <div class="text-sm mt-2 text-gray-600">
                                Ambil Foto
                            </div>
                        </div>
                    </div>

                    <div id="photoPreview" class="mt-3 hidden">
                        <img id="previewImage"
                             class="w-full h-40 object-cover rounded-xl shadow-sm">
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                            id="cancelReturnBtn"
                            class="px-5 py-2 rounded-xl border text-gray-600">
                        Batal
                    </button>

                   <button type="submit"
        id="submitReturnBtn"
        class="px-6 py-2 rounded-xl bg-emerald-700 text-white hover:bg-emerald-800 transition flex items-center gap-2 justify-center">
        
    <span id="returnBtnText">Selesaikan Pengembalian</span>

    <svg id="returnBtnLoader"
         class="animate-spin h-4 w-4 hidden"
         xmlns="http://www.w3.org/2000/svg"
         fill="none"
         viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
        <path class="opacity-75" fill="white"
              d="M4 12a8 8 0 018-8v8H4z"></path>
    </svg>

</button>
                </div>

            </form>

        </div>
    </div>
</div>
<div id="detailReturnModal"
     class="fixed inset-0 z-[9999] hidden">

    <div class="fixed inset-0 bg-black/40"></div>

    <div class="fixed inset-0 flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl p-6">

            <h2 class="text-lg font-semibold mb-4">
                Detail Pengembalian
            </h2>

            <div id="detailReturnContent"></div>

            <div class="flex justify-end mt-6">
                <button id="closeDetailModal"
                        class="px-4 py-2 border rounded-xl">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
<div id="logbookModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center">

    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    <div class="relative bg-white w-full max-w-xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl p-6">

        <div class="bg-white w-full max-w-xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl p-6 relative">

            <button id="closeLogbookModal"
                    class="absolute top-4 right-4 text-gray-400">✕</button>

            <h2 class="text-lg font-semibold mb-1">
                Isi Logbook Praktikum
            </h2>

            <p class="text-sm text-emerald-700 mb-6">
                Dokumentasikan aktivitas dan kompetensi yang dicapai
            </p>

            <form id="logbookForm" enctype="multipart/form-data" class="space-y-4">

                @csrf

               <div>
    <label class="text-sm font-medium text-gray-700">
        Sesi Praktikum
    </label>

    <select id="sessionSelect"
            name="session_name"
            class="w-full mt-2 rounded-xl bg-emerald-50 border-0 px-4 py-3 text-sm">
        <option value="">Pilih sesi</option>

        @foreach($sessions as $session)
            <option value="{{ $session->id }}">
                {{ $session->judul }} - {{ \Carbon\Carbon::parse($session->tanggal)->format('d M Y') }}
            </option>
        @endforeach

    </select>
</div>

                <textarea name="activity"
                          placeholder="Deskripsikan aktivitas praktikum..."
                          class="w-full bg-emerald-50 rounded-xl px-4 py-3"></textarea>

                <div>
                    <label class="block mb-2">Kompetensi</label>
                    <label><input type="checkbox" name="competencies[]" value="Diagnosis"> Diagnosis</label>
                    <label><input type="checkbox" name="competencies[]" value="Preparasi"> Preparasi</label>
                    <label><input type="checkbox" name="competencies[]" value="Obturasi"> Obturasi</label>
                </div>

                <div>
    <label class="text-sm font-medium text-gray-700">
        Upload Dokumentasi (Foto/Video)
    </label>

    <div class="mt-2 border border-dashed border-emerald-200 rounded-xl p-6 text-center cursor-pointer hover:bg-emerald-50 transition relative">

        <input type="file"
               name="documentation"
               id="docInput"
               accept="image/*,video/*"
               class="absolute inset-0 opacity-0 cursor-pointer">

        <div id="uploadArea">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-6 h-6 mx-auto text-gray-500"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>

            <div class="text-sm mt-2 text-gray-600">
                Pilih File
            </div>
        </div>

    </div>

    {{-- PREVIEW --}}
    <div id="docPreview" class="mt-4 hidden"></div>
</div>

                <div class="flex justify-end gap-3 pt-4">

                    <button type="button"
                            id="saveDraft"
                            class="px-4 py-2 border rounded-xl">
                        Simpan Draft
                    </button>

                    <button type="button"
                            id="submitLogbook"
                            class="px-5 py-2 bg-emerald-700 text-white rounded-xl flex items-center gap-2">
                        <span id="logbookBtnText">Submit Logbook</span>
                        <svg id="logbookLoader"
                             class="hidden animate-spin h-4 w-4"
                             viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"
                                    stroke="white"
                                    stroke-width="4"
                                    fill="none"/>
                        </svg>
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
let current = new Date()

function renderCalendar() {
    const year = current.getFullYear()
    const month = current.getMonth()
    const daysInMonth = new Date(year, month + 1, 0).getDate()

    $('#calendarTitle').text(
        current.toLocaleString('id-ID', { month: 'long', year: 'numeric' })
    )

    let html = ''
    for (let d = 1; d <= daysInMonth; d++) {
        const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`

        html += `
        <button data-date="${dateStr}"
            class="calendar-day w-8 h-8 rounded-full hover:bg-emerald-50">
            ${d}
        </button>`
    }

    $('#calendarGrid').html(html)
}

$(document).on('click', '.calendar-day', function () {
    const date = $(this).data('date')

    $.get('/mahasiswa/jadwal/by-date', { start: date }, function(res) {
        $('#scheduleList').html(res)
    })
})


// ===============================
// OPEN MODAL RESERVASI
// ===============================
$(document).on('click', '#openReservation', function () {
    $('#reservationModal').removeClass('hidden').addClass('flex')
})

// CLOSE MODAL RESERVASI
$(document).on('click', '#closeModal, #cancelBtn', function () {
    $('#reservationModal').addClass('hidden').removeClass('flex')
})

// ===============================
// OPEN MODAL LOAN
// ===============================
$(document).on('click', '#openLoan', function () {

    $('#loanModal').removeClass('hidden').addClass('flex')

    setTimeout(function () {

        if ($('#alatSelect').hasClass("select2-hidden-accessible")) {
            $('#alatSelect').select2('destroy');
        }

        $('#alatSelect').select2({
            dropdownParent: $('#loanModal'),
            placeholder: "Pilih alat",
            width: '100%'
        })

    }, 100)
})

// CLOSE MODAL LOAN
$(document).on('click', '#closeLoanModal, #cancelLoanBtn', function () {
    $('#loanModal').addClass('hidden').removeClass('flex')
    
})
// Submit AJAX
$('#reservationForm').submit(function(e){
    e.preventDefault()

    $.ajax({
        url: '/mahasiswa/reservasi/store',
        type: 'POST',
        data: $(this).serialize(),
        success: function(res){
            alert(res.message)
            $('#reservationModal').addClass('hidden')
            $('#reservationForm')[0].reset()
        },
        error: function(err){
            alert('Terjadi kesalahan.')
        }
    })
})

// Submit AJAX
$('#loanForm').submit(function(e){
    e.preventDefault()

    $.ajax({
        url: '/mahasiswa/peminjaman/store',
        type: 'POST',
        data: $(this).serialize(),
        success: function(res){
           Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: res.message,
        confirmButtonColor: '#047857'
    })
          $('#loanModal').addClass('hidden')
    $('#loanForm')[0].reset()
document.querySelector('[x-data]').__x.$data.tab = 'peminjaman';
    loadLoanList()
        },
        error: function(err){
           Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: err.responseJSON?.message ?? 'Terjadi kesalahan',
        confirmButtonColor: '#dc2626'
    })
        }
    })
})
function loadLoanList() {
    $.get('/mahasiswa/peminjaman/list', function(res) {
        $('#loanListContainer').html(res)
    })
}
function loadLogbookList() {
    $.get('/mahasiswa/logbook/list', function(res) {
        $('#logbookList').html(res)
    })
}
$(document).ready(function(){
    renderCalendar()
    loadLoanList()
    loadLogbookList()
})
function lockBodyScroll() {
    $('body').addClass('overflow-hidden');
}

function unlockBodyScroll() {
    $('body').removeClass('overflow-hidden');
}

// OPEN MODAL
$(document).on('click', '.returnBtn', function(){

    $('#returnLoanId').val($(this).data('loan'))
    $('#returnLoanItemId').val($(this).data('loanitem'))

    $('#returnItemName').text(
        $(this).data('name') + ' (' + $(this).data('qty') + 'x)'
    )

    $('#returnItemCode').text(
        'ID: ' + $(this).data('code')
    )

    $('#returnDueDate').text(
        'Batas: ' + $(this).data('due')
    )

    $('#returnTitle').text(
        'Pengembalian Alat - ' + $(this).data('name')
    )

    $('#returnModal').removeClass('hidden').addClass('flex')
})

// CLOSE
$(document).on('click', '#closeReturnModal, #cancelReturnBtn', function(){
    $('#returnModal').addClass('hidden').removeClass('flex')
})

// FOTO PREVIEW
$('#returnPhotoInput').on('change', function(e){

    const file = e.target.files[0]

    if(file){
        const reader = new FileReader()

        reader.onload = function(event){
            $('#previewImage').attr('src', event.target.result)
            $('#photoPreview').removeClass('hidden')
        }

        reader.readAsDataURL(file)
    }
})

// SUBMIT RETURN
$('#returnForm').submit(function(e){
    e.preventDefault()

    let formData = new FormData(this)

    $('#submitReturnBtn').prop('disabled', true).addClass('opacity-70 cursor-not-allowed')
    $('#returnBtnLoader').removeClass('hidden')
    $('#returnBtnText').text('Memproses...')

    $.ajax({
        url: '/mahasiswa/pengembalian/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res){

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Pengembalian berhasil diproses',
                timer: 2000,
                showConfirmButton: false
            })

            $('#returnModal').addClass('hidden')

            // UPDATE CARD JADI DIKEMBALIKAN
            let card = $(`.loan-card[data-loan="${res.loan_id}"]`)

            card.find('.loan-status')
                .removeClass('bg-yellow-100 text-yellow-700')
                .addClass('bg-emerald-100 text-emerald-700')
                .text('Dikembalikan')

            card.find('.btn-return')
                .removeClass('btn-return')
                .addClass('btn-detail')
                .text('Detail Pengembalian')

        },
        error: function(err){
            Swal.fire('Error', err.responseJSON?.message ?? 'Terjadi kesalahan', 'error')
        },
        complete: function(){
            $('#submitReturnBtn').prop('disabled', false)
                .removeClass('opacity-70 cursor-not-allowed')

            $('#returnBtnLoader').addClass('hidden')
            $('#returnBtnText').text('Selesaikan Pengembalian')
        }
    })
})
$(document).on('click', '.btn-detail-kembali', function(){

    let loanId = $(this).closest('.loan-card').data('loan')

    $.get('/mahasiswa/pengembalian/detail/' + loanId, function(res){

        $('#detailReturnContent').html(`
            <div class="space-y-4 text-sm">

                <div>
                    <div class="font-medium text-slate-700">Kondisi</div>
                    <div class="text-slate-800">${res.condition}</div>
                </div>

                <div>
                    <div class="font-medium text-slate-700">Catatan</div>
                    <div class="text-slate-800">${res.note ?? '-'}</div>
                </div>

                <div>
                    <div class="font-medium text-slate-700">Tanggal Pengembalian</div>
                    <div class="text-slate-800">${res.returned_at}</div>
                </div>

                ${res.photo 
                    ? `<div>
                         <div class="font-medium text-slate-700 mb-2">Foto</div>
                         <img src="/storage/${res.photo}" class="rounded-xl shadow">
                       </div>`
                    : ''
                }

            </div>
        `)

        $('#detailReturnModal').removeClass('hidden')
    })
})

$(document).on('click', '#closeDetailModal', function(){
    $('#detailReturnModal').addClass('hidden')
})
// =============================
// OPEN LOGBOOK MODAL
// =============================
$(document).on('click', '#openLogbook', function () {

    $('#logbookModal')
        .removeClass('hidden')
        .addClass('flex')

    // Aktifkan Select2 setelah modal muncul
    setTimeout(function () {

        if ($('#sessionSelect').hasClass("select2-hidden-accessible")) {
            $('#sessionSelect').select2('destroy')
        }

        $('#sessionSelect').select2({
            dropdownParent: $('#logbookModal'),
            placeholder: "Pilih sesi praktikum",
            width: '100%'
        })

    }, 100)
})

// =============================
// CLOSE LOGBOOK MODAL
// =============================
$(document).on('click', '#closeLogbookModal', function () {
    $('#logbookModal')
        .addClass('hidden')
        .removeClass('flex')
})
function submitLogbook(type) {

    let form = $('#logbookForm')[0]
    let formData = new FormData(form)
    formData.append('submit_type', type)

    $('#submitLogbook').prop('disabled', true)
    $('#logbookLoader').removeClass('hidden')
    $('#logbookBtnText').text('Memproses...')

    $.ajax({
        url: '/mahasiswa/logbook/store',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

   success: function(res){

    $('#logbookModal').addClass('hidden').removeClass('flex')

    $('#logbookForm')[0].reset()
    $('#docPreview').addClass('hidden').html('')

    document.getElementById('mainTab').__x.$data.tab = 'logbook'

    loadLogbookList()

    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Logbook berhasil disimpan',
        timer: 1500,
        showConfirmButton: false
    })
},

        complete: function(){
            $('#submitLogbook').prop('disabled', false)
            $('#logbookLoader').addClass('hidden')
            $('#logbookBtnText').text('Submit Logbook')
        }
    })
}

$('#submitLogbook').click(function(){
    submitLogbook('submit')
})

$('#saveDraft').click(function(){
    submitLogbook('draft')
})
$('#sessionSelect').select2({
    dropdownParent: $('#logbookModal'),
    placeholder: "Pilih sesi praktikum",
    width: '100%'
})
$('#docInput').on('change', function(e){

    let file = e.target.files[0]
    if(!file) return

    let reader = new FileReader()

    reader.onload = function(e){

        if(file.type.startsWith('image')){
            $('#docPreview').html(`
                <img src="${e.target.result}"
                     class="w-full h-40 object-cover rounded-xl shadow">
            `)
        }
        else if(file.type.startsWith('video')){
            $('#docPreview').html(`
                <video controls class="w-full rounded-xl shadow">
                    <source src="${e.target.result}">
                </video>
            `)
        }

        $('#docPreview').removeClass('hidden')
    }

    reader.readAsDataURL(file)
})
</script>
@endpush