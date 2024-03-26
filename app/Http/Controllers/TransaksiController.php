<?php

namespace App\Http\Controllers;
use App\Http\Requests\TransaksiRequest;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(){
        $items = DB::table('master_items')->get();
        $transaksi = DB::table('transaksi')
            ->select('transaksi.id', 'transaksi.kuantiti','transaksi.kode_barang','master_items.nama_barang',)
            ->join('master_items', 'transaksi.kode_barang', '=', 'master_items.kode_barang')
            // ->where('countries.country_name', $country)
            ->orderBy('transaksi.id','DESC')->get();

        return response()->json(['msg' => 'Berhasil', 'data' => ["data"=>$transaksi,"items"=>  $items], 'status_code' => 1], 200);
    }
    public function getDataId($id){
        $transaksi = DB::table('transaksi')
            ->select('transaksi.id', 'transaksi.kuantiti','transaksi.kode_barang','master_items.nama_barang',)
            ->join('master_items', 'transaksi.kode_barang', '=', 'master_items.kode_barang')
            ->where('transaksi.id', $id)
            // ->orderBy('transaksi.id','DESC')
            ->get();

        return response()->json(['msg' => 'Berhasil', 'data' => $transaksi, 'status_code' => 1], 200);
    }    
    public function dataItems(){
        $items = DB::table('master_items')->get();
        return response()->json(['msg' => 'Berhasil', 'data' => $items], 200);
    }
    public function insertData(Request $request) 
    {

        $validator = Validator::make($request->all(), [
            'kode_barang' => 'required',
            'kuantiti' => 'required|integer',
        ]);        
        $getPost = $request->all();
        if($validator->fails()) {

            $res = [
                'data'=>[],
                'msg'=>$validator->errors()->first(),
                'status_code' => 0
            ];
            $code=400;       
        }
        else
        {
            $data= [
                'kode_barang' => $getPost['kode_barang'],
                'kuantiti' => $getPost['kuantiti']
            ];        
            DB::table('transaksi')->insert($data);
            $res = ['msg' => 'Berhasil Tambah Data', 'data' => $getPost, 'status_code' => 1];
            $code=200; 
        }        
        
        return response()->json($res,$code);
    }
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_barang' => 'required',
            'id' => 'required',
            'kuantiti' => 'required|integer',
        ]);        
        $getPost = $request->all();
        if($validator->fails()) {

            $res = [
                'data'=>[],
                'msg'=>$validator->errors()->first(),
                'status_code' => 0,
            ];
            $code=400;       
        }
        else
        {
            $data= [
                'kode_barang' => $getPost['kode_barang'],
                'kuantiti' => $getPost['kuantiti']
            ];        
            DB::table('transaksi')
                  ->where('id', $getPost['id'])
                  ->update($data);

            $res = ['msg' => 'Berhasil Update Data', 'data' => $getPost,'status_code' => 1];
            $code=200; 
        }      

        return response()->json($res, $code);
    }    
    function deletData($id)
    {
        DB::table('transaksi')->where('id', $id)->delete();
        return response()->json(['msg' => 'Berhasil Hapus Data', 'data' =>$id, 'status_code' => 1], 200);
    }
}
