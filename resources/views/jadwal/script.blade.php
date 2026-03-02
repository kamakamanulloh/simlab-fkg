<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalJadwal');
    const form  = document.getElementById('formJadwalBaru');
    const openBtn = document.getElementById('btnOpenModalJadwal');
    const closeBtn = document.getElementById('btnCloseModalJadwal');
    const cancelBtn = document.getElementById('btnCancelModalJadwal');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        form.reset();
    }

    openBtn.onclick = openModal;
    closeBtn.onclick = closeModal;
    cancelBtn.onclick = closeModal;

    modal.onclick = e => {
        if (e.target === modal) closeModal();
    };

    // // Submit form AJAX
    // $('#formJadwalBaru').on('submit', function (e) {
    //     e.preventDefault();

    //     const btn = $(this).find('button[type="submit"]');
    //     btn.prop('disabled', true).text('Menyimpan...');

    //     $.post({
    //         url: form.action,
    //         data: $(this).serialize(),
    //         success: function (res) {
    //             btn.prop('disabled', false).text('Ajukan Jadwal');
    //             closeModal();

    //             Swal.fire({
    //                 icon: 'success',
    //                 title: 'Berhasil',
    //                 text: res.message,
    //                 confirmButtonColor: '#059669'
    //             }).then(() => {
    //                 window.location.reload();
    //             });
    //         },
    //         error: function (xhr) {
    //             btn.prop('disabled', false).text('Ajukan Jadwal');

    //             if (xhr.status === 422) {
    //                 let errors = Object.values(xhr.responseJSON.errors)
    //                     .map(e => e.join('<br>'))
    //                     .join('<br>');

    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Validasi Gagal',
    //                     html: errors
    //                 });
    //             } else {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error',
    //                     text: 'Terjadi kesalahan server.'
    //                 });
    //             }
    //         }
    //     });
    // });
    $('#instruktur_id').select2({
    dropdownParent: $('#modalJadwal'),
    placeholder: "Pilih Instruktur",
    width: '100%'
});
});
</script>
