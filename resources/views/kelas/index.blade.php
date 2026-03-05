@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <h1 class="text-2xl font-semibold">
            Manajemen Kelas
        </h1>

        <button id="btnTambah"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">

            + Tambah Kelas

        </button>

    </div>


    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-gray-700">

            <tr>

                <th class="p-3 text-left">Kelas</th>
                <th class="p-3 text-left">Angkatan</th>
                <th class="p-3 text-left">Mahasiswa</th>
                <th class="p-3 text-left w-52">Aksi</th>

            </tr>

            </thead>

            <tbody>

            @foreach($kelas as $k)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-3 font-semibold">
                    {{$k->nama_kelas}}
                </td>

                <td class="p-3">
                    {{$k->angkatan}}
                </td>

                <td class="p-3">

                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">

                        {{$k->mahasiswa_count}} Mahasiswa

                    </span>

                </td>

                <td class="p-3 space-x-2">

                    <button
                    data-kelas="{{$k->id}}"
                    class="btnMahasiswa bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded">

                        Mahasiswa

                    </button>

                    <button
                    data-id="{{$k->id}}"
                    data-nama="{{$k->nama_kelas}}"
                    data-angkatan="{{$k->angkatan}}"
                    class="btnEdit bg-yellow-400 hover:bg-yellow-500 px-3 py-1 rounded">

                        Edit

                    </button>

                    <button
                    data-id="{{$k->id}}"
                    class="btnHapus bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">

                        Hapus

                    </button>

                </td>

            </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

@include('kelas.modal')

@endsection
@push('scripts')

<script>

$(function(){

let kelasAktif = ''

/* =========================
   MODAL KELAS
========================= */

$('#btnTambah').click(function(){

    $('#modalKelas').removeClass('hidden').addClass('flex')

    $('#id').val('')
    $('#nama_kelas').val('')
    $('#angkatan').val('')

})


$('#batalKelas').click(function(){

    $('#modalKelas').addClass('hidden').removeClass('flex')

})


/* =========================
   EDIT KELAS
========================= */

$('.btnEdit').click(function(){

    $('#modalKelas').removeClass('hidden').addClass('flex')

    $('#id').val($(this).data('id'))
    $('#nama_kelas').val($(this).data('nama'))
    $('#angkatan').val($(this).data('angkatan'))

})


/* =========================
   SIMPAN KELAS
========================= */

$('#simpanKelas').click(function(){

    let nama = $('#nama_kelas').val()

    if(nama === ''){
        Swal.fire('Nama kelas wajib diisi')
        return
    }

    showLoading()

    let id = $('#id').val()
    let url = id ? '/kelas/update' : '/kelas/store'

    $.post(url,{

        _token:$('meta[name="csrf-token"]').attr('content'),

        id:id,
        nama_kelas:nama,
        angkatan:$('#angkatan').val()

    })

    .done(function(){

        hideLoading()

        Swal.fire({
            icon:'success',
            title:'Berhasil',
            text:'Data kelas berhasil disimpan',
            timer:1500,
            showConfirmButton:false
        })

        setTimeout(()=>{
            location.reload()
        },1500)

    })

    .fail(function(){

        hideLoading()

        Swal.fire('Terjadi kesalahan')

    })

})


/* =========================
   LIHAT MAHASISWA
========================= */

$(document).on('click','.btnMahasiswa',function(){

    kelasAktif = $(this).data('kelas')

    $('#modalMahasiswa').removeClass('hidden').addClass('flex')

    loadMahasiswa()

})



function loadMahasiswa(){

$('#tableMahasiswa').DataTable({

processing:true,
serverSide:true,
destroy:true,

ajax:{
url:'/kelas/datatable-mahasiswa/'+kelasAktif
},

pageLength:5,
lengthChange:false,

columns:[
{data:0},
{data:1},
{data:2}
]

});

}


/* =========================
   HAPUS KELAS
========================= */

$('.btnHapus').click(function(){

    let id=$(this).data('id')

    Swal.fire({
        title:'Hapus kelas?',
        text:'Data tidak dapat dikembalikan',
        icon:'warning',
        showCancelButton:true,
        confirmButtonText:'Ya Hapus'
    })

    .then((result)=>{

        if(result.isConfirmed){

            showLoading()

            $.ajax({

                url:'/kelas/delete/'+id,
                type:'DELETE',

                data:{
                    _token:$('meta[name="csrf-token"]').attr('content')
                }

            })

            .done(function(){

                hideLoading()

                Swal.fire({
                    icon:'success',
                    title:'Berhasil',
                    text:'Kelas berhasil dihapus',
                    timer:1500,
                    showConfirmButton:false
                })

                setTimeout(()=>{
                    location.reload()
                },1500)

            })

        }

    })

})


/* =========================
   TAMBAH MAHASISWA
========================= */

$(document).on('click','#btnTambahMahasiswa',function(){


    $('#modalTambahMahasiswa').removeClass('hidden').addClass('flex')

    loadCalonMahasiswa()

})




function loadCalonMahasiswa(){

$('#tableCalonMahasiswa').DataTable({

processing:true,
serverSide:true,
destroy:true,

ajax:{
url:'/kelas/datatable-calon'
},

pageLength:5,
lengthChange:false,

columns:[
{data:0, orderable:false},
{data:1},
{data:2}
]

});

}


/* =========================
   CHECK ALL
========================= */

$(document).on('click','#checkAll',function(){

$('.checkMhs').prop('checked',$(this).prop('checked'))

})

/* =========================
   SIMPAN MAHASISWA
========================= */

$('#simpanMahasiswa').click(function(){

    let ids=[]

    $('.checkMhs:checked').each(function(){

        ids.push($(this).val())

    })

    if(ids.length===0){

        Swal.fire({
            icon:'warning',
            title:'Pilih mahasiswa terlebih dahulu'
        })

        return
    }

    showLoading()

    $.post('/kelas/tambah-mahasiswa',{

        _token:$('meta[name="csrf-token"]').attr('content'),

        ids:ids,
        kelas:kelasAktif

    })

    .done(function(){

        hideLoading()

        Swal.fire({
            icon:'success',
            title:'Berhasil',
            text:'Mahasiswa berhasil ditambahkan',
            timer:1500,
            showConfirmButton:false
        })

        $('#modalTambahMahasiswa').addClass('hidden')

        loadMahasiswa()

    })

})


/* =========================
   BATAL TAMBAH MAHASISWA
========================= */

$('#batalTambahMahasiswa').click(function(){

    $('#modalTambahMahasiswa').addClass('hidden')

})
$('#tutupMahasiswa').click(function(){

    $('#modalMahasiswa').addClass('hidden')

})
function closeModal(id){

$('#'+id).addClass('hidden')

}
})

</script>
@endpush