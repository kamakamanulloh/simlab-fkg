{{-- MODAL KELAS --}}

<div id="modalKelas"
class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

<div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">

<h2 class="text-lg font-semibold mb-4">
Data Kelas
</h2>

<input type="hidden" id="id">

<div class="space-y-3">

<div>

<label class="text-sm">Nama Kelas</label>

<input
type="text"
id="nama_kelas"
class="w-full border rounded-lg px-3 py-2">

</div>

<div>

<label class="text-sm">Angkatan</label>

<input
type="text"
id="angkatan"
class="w-full border rounded-lg px-3 py-2">

</div>

</div>

<div class="flex justify-end gap-2 mt-5">

<button id="batalKelas"
class="px-4 py-2 border rounded">

Batal

</button>

<button id="simpanKelas"
class="bg-blue-600 text-white px-4 py-2 rounded">

Simpan

</button>

</div>

</div>

</div>



{{-- MODAL MAHASISWA --}}

<div id="modalMahasiswa"
class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

<div class="bg-white rounded-xl shadow-lg w-full max-w-4xl p-6 max-h-[80vh] overflow-y-auto">

<h2 class="text-lg font-semibold mb-4">

Data Mahasiswa

</h2>


<div class="flex justify-between mb-4">


<button
id="btnTambahMahasiswa"
class="bg-green-600 text-white px-4 py-2 rounded">

Tambah Mahasiswa

</button>

</div>


<table  id="tableMahasiswa" class="w-full text-sm">

<thead class="bg-gray-100">

<tr>

<th class="p-2 text-left">NIM</th>
<th class="p-2 text-left">Nama</th>
<th class="p-2 text-left w-32">Aksi</th>

</tr>

</thead>

<tbody id="dataMahasiswa"></tbody>

</table>
<button
id="tutupMahasiswa"
class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">

Tutup

</button>
</div>


</div>

{{-- MODAL TAMBAH MAHASISWA --}}

<div id="modalTambahMahasiswa"
class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

<div class="bg-white rounded-xl shadow-lg w-full max-w-3xl p-6 max-h-[80vh] overflow-y-auto">

<h2 class="text-lg font-semibold mb-4">
Tambah Mahasiswa
</h2>

<table  id="tableCalonMahasiswa" class="w-full text-sm">

<thead class="bg-gray-100">

<tr>

<th class="p-2 w-10">
<input type="checkbox" id="checkAll">
</th>

<th class="p-2 text-left">NIM</th>
<th class="p-2 text-left">Nama</th>

</tr>

</thead>

<tbody id="dataCalonMahasiswa">

</tbody>

</table>


<div class="flex justify-end gap-2 mt-4">

<button
id="batalTambahMahasiswa"
class="px-4 py-2 border rounded">

Batal

</button>

<button
id="simpanMahasiswa"
class="bg-green-600 text-white px-4 py-2 rounded">

Tambahkan

</button>

</div>

</div>

</div>