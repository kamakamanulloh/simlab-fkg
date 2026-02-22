import $ from 'jquery'

let current = new Date()

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

$(document).on('click', '.calendar-day', function () {
    const date = $(this).data('date')

    $('.calendar-day').removeClass('bg-emerald-600 text-white')
    $(this).addClass('bg-emerald-600 text-white')

    $('#scheduleList').html('<div class="text-xs text-slate-500">Memuat jadwal...</div>')

    $.get('/jadwal/by-date', { tanggal: date }, function (res) {
        $('#scheduleList').html(res)
    })
})

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

                reloadScheduleList();
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
        reloadScheduleList();
    }
});

            }
        });
    });

    // === RELOAD LIST ===
    function reloadScheduleList() {
        $('#scheduleList').load(location.href + ' #scheduleList>*');
    }

});

