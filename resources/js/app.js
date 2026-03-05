import $ from 'jquery'
window.$ = window.jQuery = $

import select2 from 'select2'
select2($)

import 'select2/dist/css/select2.css'

import 'datatables.net-dt'
import 'datatables.net-dt/css/dataTables.dataTables.css'

import './bootstrap'

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


window.showLoading = function(){
    $('#globalLoading').removeClass('hidden').addClass('flex')
}

window.hideLoading = function(){
    $('#globalLoading').removeClass('flex').addClass('hidden')
}
