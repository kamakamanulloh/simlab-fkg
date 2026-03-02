document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('maintenanceModal')
    const openBtn = document.getElementById('btnOpenMaintenanceModal')
    const closeBtns = document.querySelectorAll('.btnCloseModal')

    if (!modal || !openBtn) return

    openBtn.addEventListener('click', () => {
        modal.classList.remove('hidden')
        modal.classList.add('flex')
    })

    closeBtns.forEach(btn => {
        btn.addEventListener('click', () => closeModal())
    })

    modal.addEventListener('click', e => {
        if (e.target === modal) closeModal()
    })

    function closeModal() {
        modal.classList.add('hidden')
        modal.classList.remove('flex')
    }
})
const costModal = document.getElementById('costModal')
const btnCost = document.getElementById('btnOpenCostModal')
const closeCostBtns = document.querySelectorAll('.btnCloseCost')

if (btnCost) {
    btnCost.addEventListener('click', () => {
        costModal.classList.remove('hidden')
        costModal.classList.add('flex')
    })
}

closeCostBtns.forEach(btn => {
    btn.addEventListener('click', () => closeCost())
})

function closeCost() {
    costModal.classList.add('hidden')
    costModal.classList.remove('flex')
}
$(document).ready(function(){

    // ==============================
    // SUBMIT ANALISIS BIAYA
    // ==============================
$('#formCost').on('submit', function(e){
    e.preventDefault();

    let form = $(this);
    let btn = form.find('button[type="submit"]');
    let originalText = btn.html();

    // 🔥 Ambil angka murni sebelum kirim
    let biayaFormatted = $('#biayaInput').val();
    let biayaClean = biayaFormatted.replace(/[^0-9]/g, '');

    // set value hidden sementara
    form.find('input[name="biaya"]').val(biayaClean);

    btn.prop('disabled', true);
    btn.html(`
        <svg class="animate-spin h-4 w-4 inline mr-2" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                stroke="currentColor" stroke-width="4" fill="none"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        Memproses...
    `);

    $.ajax({
        url: form.data('url'),
        type: "POST",
        data: form.serialize(),
        success: function(res){

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message,
                timer: 1200,
                showConfirmButton: false
            });

            form[0].reset();
            closeCost();

            // 🔥 AUTO PINDAH KE TAB ANALISIS
            window.dispatchEvent(new CustomEvent('openAnalisisTab'));
            
        },
        error: function(){
            Swal.fire('Error', 'Gagal menyimpan data', 'error');
        },
        complete: function(){
            btn.prop('disabled', false);
            btn.html(originalText);
        }
    });
});
// ==============================
// FORMAT RUPIAH REALTIME
// ==============================
$('#biayaInput').on('input', function(){

    let value = $(this).val().replace(/[^0-9]/g, '');

    if(value === ''){
        $(this).val('');
        return;
    }

    let formatted = new Intl.NumberFormat('id-ID').format(value);

    $(this).val('Rp ' + formatted);
});
});