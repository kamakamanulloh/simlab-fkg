<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;

class KelasController extends Controller
{

    public function index()
    {
        $kelas = Kelas::withCount(['mahasiswa'])->get();

        return view('kelas.index',compact('kelas'));
    }

    public function store(Request $request)
    {
        Kelas::create($request->all());

        return response()->json([
            'success'=>true,
            'message'=>'Kelas berhasil dibuat'
        ]);
    }

    public function update(Request $request)
    {
        $kelas = Kelas::find($request->id);

        $kelas->update($request->all());

        return response()->json([
            'success'=>true
        ]);
    }

    public function destroy($id)
    {
        Kelas::destroy($id);

        return response()->json([
            'success'=>true
        ]);
    }

    public function mahasiswa($kelas)
    {
        $data = User::where('role','Mahasiswa')
        ->where('kelas',$kelas)
        ->get();

        return response()->json($data);
    }

    public function calonMahasiswa()
    {
        $data = User::where('role','Mahasiswa')
        ->where('kelas','-')
        ->get();

        return response()->json($data);
    }

    public function tambahMahasiswa(Request $request)
    {
        User::whereIn('id',$request->ids)
        ->update([
            'kelas'=>$request->kelas
        ]);

        return response()->json([
            'success'=>true
        ]);
    }

    public function hapusMahasiswa($id)
    {
        User::where('id',$id)
        ->update(['kelas'=>'-']);

        return response()->json([
            'success'=>true
        ]);
    }
public function datatableMahasiswa(Request $request, $kelas)
{

    $columns = ['username','name'];

    $query = User::where('role','Mahasiswa')
                ->where('kelas',$kelas);

    $totalData = $query->count();

    if($request->search['value']){
        $search = $request->search['value'];

        $query->where(function($q) use ($search){
            $q->where('username','like',"%$search%")
              ->orWhere('name','like',"%$search%");
        });
    }

    $totalFiltered = $query->count();

    $data = $query
        ->offset($request->start)
        ->limit($request->length)
        ->get();

    $result = [];

    foreach($data as $row){

        $result[] = [
            $row->username,
            $row->name,
            '<button class="hapusMhs bg-red-500 text-white px-2 py-1 rounded"
             data-id="'.$row->id.'">Hapus</button>'
        ];

    }

    return response()->json([
        "draw" => intval($request->draw),
        "recordsTotal" => $totalData,
        "recordsFiltered" => $totalFiltered,
        "data" => $result
    ]);
}
public function datatableCalonMahasiswa(Request $request)
{

    $query = User::where('role','Mahasiswa')
                ->where('kelas','-');

    $totalData = $query->count();

    if($request->search['value']){

        $search = $request->search['value'];

        $query->where(function($q) use ($search){
            $q->where('username','like',"%$search%")
              ->orWhere('name','like',"%$search%");
        });

    }

    $totalFiltered = $query->count();

    $data = $query
        ->offset($request->start)
        ->limit($request->length)
        ->get();

    $result = [];

    foreach($data as $row){

        $result[] = [
            '<input type="checkbox" class="checkMhs" value="'.$row->id.'">',
            $row->username,
            $row->name
        ];

    }

    return response()->json([
        "draw" => intval($request->draw),
        "recordsTotal" => $totalData,
        "recordsFiltered" => $totalFiltered,
        "data" => $result
    ]);
}
}