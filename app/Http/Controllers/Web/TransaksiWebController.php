<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response ;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\TransaksiRequest;

class TransaksiWebController extends Controller
{
    public function index()
    {

       $data = $this->getAllData();
        return  view('view_transaksi', $data);
    }
    public function getDataId(Request $request) :RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);        
        if($validator->fails()) {

            $data = [
                'data'=>[],
                'msg'=>$validator->errors()->first(),
                'status_code'=>0
            ];
            echo json_encode($data);
            exit;
        }
        $getPost = $request->all();
        $id = $getPost['id'];

        $dataHeader = array(
            "cache-control: no-cache",
            "Content-Type:application/json; charset=utf-8"
        );

		$arraySetting =array(
            CURLOPT_URL => 'http://127.0.0.1:8000/api/transaksi/'.$id,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",   
            CURLOPT_USERPWD => 'admin:admin',        
            CURLOPT_HTTPHEADER => $dataHeader
        );

		$curl = curl_init();        
        curl_setopt_array($curl,$arraySetting);

        $response = curl_exec($curl);
        $err = curl_error($curl);	

        if ($response === false) {
            return json_decode($err);
            exit;
        }

        $getResponse = json_decode($response);
        $data = [
            'data'=>$getResponse->data[0],
            'msg'=>"Berhasil Tampil Data",
            'status_code'=>0
        ];
        echo json_encode($data);
        exit;        
    }    

    public function getAllData()
    {

        $dataHeader = array(
            "cache-control: no-cache",
            "Content-Type:application/json; charset=utf-8"
        );

		$arraySetting =array(
            CURLOPT_URL => 'http://127.0.0.1:8000/api/transaksi',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            // CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_USERPWD => 'admin:admin',                  
            CURLOPT_HTTPHEADER => $dataHeader
        );
		// print_r($arraySetting); exit;

		$curl = curl_init();        
        curl_setopt_array($curl,$arraySetting);

        $response = curl_exec($curl);
        $err = curl_error($curl);	


        if ($response === false) {
            return json_decode($err);
            exit;
        }

        $getResponse = json_decode($response);
        $data=[
            "data"=>$getResponse->data->data,
            "items"=>$getResponse->data->items
        ];        

        return   $data;
    }

    function saveData(Request $request) :RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'kode_barang' => 'required',
            'kuantiti' => 'required|integer',
        ]);        

        if($validator->fails()) {

            $data = [
                'data'=>[],
                'msg'=>$validator->errors()->first(),
                'status_code'=>0
            ];
            echo json_encode($data);
            exit;
        }

        $data = $request->all();
        $dataHeader = array(
            "cache-control: no-cache",
            "Content-Type:application/json; charset=utf-8"
        );
		$arraySetting =array(
            CURLOPT_URL => 'http://127.0.0.1:8000/api/transaksi/insert',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_USERPWD => 'admin:admin',           
            CURLOPT_HTTPHEADER => $dataHeader
        );
		// print_r($arraySetting); exit;

		$curl = curl_init();        
        curl_setopt_array($curl,$arraySetting);

        $response = curl_exec($curl);
        $err = curl_error($curl);	

        if ($response === false) {
            // return json_decode($err);
            // exit;
            $data = [
                'data'=>[],
                'msg'=>'API Error',
                'status_code'=>0
            ];
            echo json_encode($data);
            exit;            
        }
        else
        {
            $data = [
                'data'=>$this->getAllData(),
                'msg'=>'Berhasil Tambah Data',
                'status_code'=>1
            ];
            echo json_encode($data);
            exit;       
        }


    }
    function updateData(Request $request) :RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'kode_barang' => 'required',
            'kuantiti' => 'required',
            'id' => 'required',
        ]);        

        if($validator->fails()) {

            $data = [
                'data'=>[],
                'msg'=>$validator->errors()->first(),
                'status_code'=>0
            ];
            echo json_encode($data);
            exit;
        }

        $data = $request->all();
        $dataHeader = array(
            "cache-control: no-cache",
            "Content-Type:application/json; charset=utf-8"
        );
		$arraySetting =array(
            CURLOPT_URL => 'http://127.0.0.1:8000/api/transaksi/update_data',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_USERPWD => 'admin:admin',           
            CURLOPT_HTTPHEADER => $dataHeader
        );
		// print_r($arraySetting); exit;

		$curl = curl_init();        
        curl_setopt_array($curl,$arraySetting);

        $response = curl_exec($curl);
        $err = curl_error($curl);	

        if ($response === false) {
            // return json_decode($err);
            // exit;
            $data = [
                'data'=>[],
                'msg'=>'API Error',
                'status_code'=>0
            ];
            echo json_encode($data);
            exit;            
        }
        else
        {
            $data = [
                'data'=>$this->getAllData(),
                'msg'=>'Berhasil Update Data',
                'status_code'=>1
            ];
            echo json_encode($data);
            exit;       
        }

    }    
    function deleteData(Request $request) :RedirectResponse
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);        
        if($validator->fails()) {

            $data = [
                'data'=>[],
                'msg'=>$validator->errors()->first(),
                'status_code'=>0
            ];
            echo json_encode($data);
            exit;
        }
        $getPost = $request->all();
        $id = $getPost['id'];

        $dataHeader = array(
            "cache-control: no-cache",
            "Content-Type:application/json; charset=utf-8"
        );

		$arraySetting =array(
            CURLOPT_URL => 'http://127.0.0.1:8000/api/transaksi/delete/'.$id,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POST => 1,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            // CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_USERPWD => 'admin:admin',            
            CURLOPT_HTTPHEADER => $dataHeader
        );
		// print_r($arraySetting); exit;

		$curl = curl_init();        
        curl_setopt_array($curl,$arraySetting);

        $response = curl_exec($curl);
        $err = curl_error($curl);	

        if ($response === false) {
            // return json_decode($err);
            // exit;
            $data = [
                'data'=>[],
                'msg'=>'API Error',
                'status_code'=>0
            ];
            echo json_encode($data);
            exit;            
        }
        else
        {
            $data = [
                'data'=>$this->getAllData(),
                'msg'=>'Berhasil Delete Data',
                'status_code'=>1
            ];
            echo json_encode($data);
            exit;       
        }
    }    
}
