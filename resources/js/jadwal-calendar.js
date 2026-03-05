import $ from 'jquery'

let current = new Date()
$(document).ready(function(){

    $('#instruktur_id').select2({
        dropdownParent: $('#modalJadwal'),
        placeholder: "Pilih Instruktur",
        width:'100%'
    })

})
function renderCalendar() {
    const year = current.getFullYear()
    const month = current.getMonth()

    const firstDay = new Date(year, month, 1).getDay()
    const daysInMonth = new Date(year, month + 1, 0).getDate()

    $('#calendarTitle').text(
        current.toLocaleString('id-ID', { month: 'long', year: 'numeric' })
    )

    let html = ''

    for (let i = 0; i < firstDay; i++) {
        html += `<div></div>`
    }

    for (let d = 1; d <= daysInMonth; d++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`

        html += `
            <button
                data-date="${dateStr}"
                class="calendar-day mx-auto my-1 flex items-center justify-center w-8 h-8 rounded-full
                text-slate-700 hover:bg-emerald-50">
                ${d}
            </button>
        `
    }

    $('#calendarGrid').html(html)
}

let startDate = null
let endDate = null

$(document).on('click', '.calendar-day', function () {

    const selectedDate = $(this).data('date')

    // Reset jika sudah ada 2 tanggal
    if (startDate && endDate) {
        startDate = null
        endDate = null
        $('.calendar-day').removeClass('bg-emerald-600 text-white')
    }

    // Set tanggal pertama
    if (!startDate) {
        startDate = selectedDate
        $(this).addClass('bg-emerald-600 text-white')
        loadSchedule(startDate, null)
        return
    }

    // Set tanggal kedua
    if (!endDate) {
        endDate = selectedDate

        // Jika user klik terbalik (akhir dulu)
        if (endDate < startDate) {
            let temp = startDate
            startDate = endDate
            endDate = temp
        }

        highlightRange()
        loadSchedule(startDate, endDate)
        updateWeekLabel(startDate)
        
    }
})
function highlightRange() {
    $('.calendar-day').each(function () {
        const date = $(this).data('date')

        if (date >= startDate && date <= endDate) {
            $(this).addClass('bg-emerald-600 text-white')
        }
    })
}
function loadSchedule(start, end) {

    $('#scheduleList').html('<div class="text-xs text-slate-500">Memuat jadwal...</div>')

    $.get('/jadwal/by-date', {
        start: start,
        end: end
    }, function (res) {
        $('#scheduleList').html(res)
    })
}
$('#btnPrevMonth').on('click', () => {
    current.setMonth(current.getMonth() - 1)
    renderCalendar()
})

$('#btnNextMonth').on('click', () => {
    current.setMonth(current.getMonth() + 1)
    renderCalendar()
})

$(document).ready(renderCalendar)

$(document).ready(function () {

    // === TOGGLE MENU 3 TITIK ===
    $(document).on('click', '.btnMenuSchedule', function (e) {
        e.stopPropagation();
        $('.menuSchedule').addClass('hidden');
        $(this).next('.menuSchedule').toggleClass('hidden');
    });

    $(document).on('click', function () {
        $('.menuSchedule').addClass('hidden');
    });

    // === EDIT ===
    $(document).on('click', '.btnEditSchedule', function () {
        const id = $(this).data('id');

        $.get(`/jadwal/${id}`, function (res) {

            $('#edit_id').val(res.id);
            $('[name="judul"]').val(res.judul);
            $('[name="jenis"]').val(res.jenis);
            $('[name="ruangan"]').val(res.ruangan);
            $('[name="tanggal"]').val(res.tanggal);
            $('[name="waktu"]').val(res.waktu);
            $('[name="instruktur"]').val(res.instruktur);
            $('[name="jumlah_peserta"]').val(res.jumlah_peserta);
            $('[name="catatan"]').val(res.catatan);

            $('#modalJadwal').removeClass('hidden').addClass('flex');
        });
    });

    // === SUBMIT EDIT ===
    $('#formJadwalBaru').on('submit', function (e) {
        e.preventDefault();

        const id = $('#edit_id').val();
        const method = id ? 'PUT' : 'POST';
        const url = id ? `/jadwal/${id}` : $(this).attr('action');

        const $btn = $(this).find('button[type="submit"]');
        $btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            success: function (res) {
                $btn.prop('disabled', false).text('Simpan');
                $('#modalJadwal').addClass('hidden');

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message
                });

                loadSchedule();
            }
        });
    });

    // === DELETE ===
    $(document).on('click', '.btnDeleteSchedule', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Hapus jadwal?',
            text: 'Data tidak bisa dikembalikan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            confirmButtonText: 'Ya, hapus'
        }).then((result) => {
            if (result.isConfirmed) {
               $.ajax({
    url: `/jadwal/${id}`,
    type: 'DELETE',
    success: function (res) {
        Swal.fire('Terhapus', res.message, 'success');
        loadSchedule();
    }
});

            }
        });
    });

    // === RELOAD LIST ===
    function loadSchedule() {
        $('#scheduleList').load(location.href + ' #scheduleList>*');
    }

});
   $('#instruktur_id').select2({
    dropdownParent: $('#modalJadwal'),
    placeholder: "Pilih Instruktur",
    width: '100%'
});
function updateWeekLabel(dateStr) {
    const date = new Date(dateStr)

    const start = new Date(date)
    start.setDate(date.getDate() - date.getDay())

    const end = new Date(start)
    end.setDate(start.getDate() + 6)

    const options = { day: 'numeric', month: 'long', year: 'numeric' }

    const label = `Jadwal minggu ini (${start.toLocaleDateString('id-ID', options)} - ${end.toLocaleDateString('id-ID', options)})`

    $('#weekLabel').text(label)
}

$(document).on('change','#kelas_id',function(){

    let kelas_id = $(this).val()

    if(!kelas_id){
        $('[name="jumlah_peserta"]').val('')
        return
    }

    $.get('/kelas/'+kelas_id+'/jumlah-mahasiswa',function(res){

        $('[name="jumlah_peserta"]').val(res.jumlah)

    })

})