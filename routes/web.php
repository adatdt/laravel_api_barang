<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\TransaksiWebController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('view_transaksi');
// });



Route::get('/', 'App\Http\Controllers\Web\TransaksiWebController@index');
Route::post('/get_data_id', 'App\Http\Controllers\Web\TransaksiWebController@getDataId');
Route::post('/save_data', 'App\Http\Controllers\Web\TransaksiWebController@saveData');
Route::post('/update_data', 'App\Http\Controllers\Web\TransaksiWebController@updateData');
Route::post('/delete_data', 'App\Http\Controllers\Web\TransaksiWebController@deleteData');

Route::get('/barang', 'App\Http\Controllers\Web\BarangWebController@index');
Route::post('/barang/get_data_id', 'App\Http\Controllers\Web\BarangWebController@getDataId');
Route::post('/barang/save_data', 'App\Http\Controllers\Web\BarangWebController@saveData');
Route::post('/barang/update_data', 'App\Http\Controllers\Web\BarangWebController@updateData');
Route::post('/barang/delete_data', 'App\Http\Controllers\Web\BarangWebController@deleteData');
