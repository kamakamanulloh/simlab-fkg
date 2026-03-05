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
        
    $('#instruktur_id').select2({
        dropdownParent: $('#modalJadwal'),
        placeholder: "Pilih Instruktur",
        width:'100%'
    })
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

    $('#instruktur_id').select2({
        dropdownParent: $('#modalJadwal'),
        placeholder: "Pilih Instruktur",
        width:'100%'
    })
});
</script>
