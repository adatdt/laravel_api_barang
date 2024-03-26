<?php

namespace App\Http\Controllers;
use App\Http\Requests\BarangRequest;
use Illuminate\Support\Facades\Validator;

use DB;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(){
        $items = DB::table('master_items')->orderBy('id','DESC')->get();
        return response()->json(['msg' => 'Berhasil', 'data' => $items], 200);
    }
    public function getDataId($id){

            $items = DB::table('master_items')->where('id', $id)->get();
            return response()->json(['msg' => 'Berhasil', 'data' => $items], 200);
    }        
    public function insertData (Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'kode_barang' => 'required',
            'nama_barang' => 'required',
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
            $checkKode = DB::table('master_items')->where("kode_barang",$getPost['kode_barang'])->get();

            if(count($checkKode)>0)
            {
                $res =['msg' => 'Kode Barang already use', 'data' => $getPost, 'status_code' => 0];
                $code =400;
            }
            else
            {
                $res =['msg' => 'Berhasil Tambah Data', 'data' => $getPost, 'status_code' => 1];
                $code =200;
    
                $data= [
                    'kode_barang' => $getPost['kode_barang'],
                    'nama_barang' => $getPost['nama_barang']
                ];        
                DB::table('master_items')->insert($data);            
            }
        }        

        return response()->json($res, $code);
    }
    public function updateData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'id' => 'required',
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
            $checkKode = DB::table('master_items')->where("kode_barang",'=',$getPost['kode_barang'])->where("id",'<>',$getPost['id'])->get();
            // die($checkKode); exit;
            if(count($checkKode)>0)
            {
                $res =['msg' => 'Kode Barang already use', 'data' => $getPost,'status_code' => 0];
                $code =400;
            }
            else
            {
                $res =['msg' => 'Berhasil Update Data', 'data' => $getPost, 'status_code' => 1];
                $code =200;
    
                $data= [
                    'kode_barang' => $getPost['kode_barang'],
                    'nama_barang' => $getPost['nama_barang']
                ];        
                DB::table('master_items')
                ->where('id', $getPost['id'])
                ->update($data);       
            }
            
        }        

        return response()->json($res, $code);        
    }    
    function deletData($id)
    {
        DB::table('master_items')->where('id', $id)->delete();
        return response()->json(['msg' => 'Berhasil Hapus Data', 'data' =>[], 'status_code' => 1], 200);
    }
}
