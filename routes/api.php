<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BarangController;
use App\Http\Middleware\BasicAuth;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('/posts', function(){
//     dd('halo');
// });

// Route::middleware(['basicAuth'])->group(function () {

// });
Route::get('/transaksi', [TransaksiController::class,'index'])->middleware(BasicAuth::class);
Route::get('/transaksi/{id}', [TransaksiController::class,'getDataId'])->middleware(BasicAuth::class);
Route::get('/transaksi/items', [TransaksiController::class,'dataItems'])->middleware(BasicAuth::class);
Route::post('transaksi/insert', [TransaksiController::class, 'insertData'])->middleware(BasicAuth::class);
Route::post('transaksi/update_data', [TransaksiController::class, 'updateData'])->middleware(BasicAuth::class);
Route::delete('transaksi/delete/{id}', [TransaksiController::class, 'deletData'])->middleware(BasicAuth::class);

Route::get('/barang', [BarangController::class,'index'])->middleware(BasicAuth::class);
Route::get('/barang/{id}', [BarangController::class,'getDataId'])->middleware(BasicAuth::class);
Route::post('barang/insert', [BarangController::class, 'insertData'])->middleware(BasicAuth::class);
Route::post('barang/update_data', [BarangController::class, 'updateData'])->middleware(BasicAuth::class);
Route::delete('barang/delete/{id}', [BarangController::class, 'deletData'])->middleware(BasicAuth::class);
// Route::get('/transaksi/update_data', function(){
//     dd('halo');
// });
