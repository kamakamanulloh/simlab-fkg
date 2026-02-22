import $ from 'jquery'
import './bootstrap';
window.formatTanggal = function(datetime) {
    if (!datetime) return '-';
    const date = new Date(datetime);
    return date.toLocaleDateString('id-ID');
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
