$(document).ready(function(){

    $('#btnBuatPelatihan').on('click', function(){
        $('#modalPelatihan').removeClass('hidden');
        $('body').addClass('overflow-hidden');
    });

    $('#closePelatihan, #cancelPelatihan').on('click', function(){
        $('#modalPelatihan').addClass('hidden');
        $('body').removeClass('overflow-hidden');
        $('#formPelatihan')[0].reset();
    });

    $('#formPelatihan').on('submit', function(e){
        e.preventDefault();

        let btn = $(this).find('button[type="submit"]');
        let originalText = btn.html();

        // 🔥 Loading state
        btn.prop('disabled', true);
       btn.html(`
    <svg class="animate-spin h-4 w-4 inline mr-2" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10"
            stroke="currentColor" stroke-width="4" fill="none"></circle>
        <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8v8H4z"></path>
    </svg>
    Menyimpan...
`);
        $.ajax({
            url: $(this).data('url'),
            method: "POST",
            data: $(this).serialize(),
            success: function(res){

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                $('#modalPelatihan').addClass('hidden');
                $('body').removeClass('overflow-hidden');
                $('#formPelatihan')[0].reset();
            },
            error: function(xhr){

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal menyimpan data'
                });
            },
            complete: function(){
                // 🔥 Restore button
                btn.prop('disabled', false);
                btn.html(originalText);
            }
        });

    });

});