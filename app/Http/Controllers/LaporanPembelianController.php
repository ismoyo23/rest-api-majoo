<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use DB;

class LaporanPembelianController extends Controller
{
    function __construct()
    {
         $this->middleware('role:admin');
    }

    public function produk(){
        try
        {
            $response = Produk::select('table_produk.produk_id', 'table_produk.name_produk', 'table_produk.harga', 'table_produk.diskripsi', 'table_suplier.nama_suplier', 'table_kategori.nama_kategori', DB::raw("COUNT(table_produk.name_produk) as count_produk"))->join('table_suplier', 'table_produk.id_suplier','=','table_produk.id_suplier')->join('table_kategori', 'table_kategori.id_kategori', '=', 'table_produk.id_kategori')->groupBy('table_produk.produk_id', 'table_produk.name_produk', 'table_produk.harga', 'table_produk.diskripsi', 'table_suplier.nama_suplier', 'table_kategori.nama_kategori')->get();
        return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $response])->setStatusCode(200);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
    }

    public function per_produk(){
        try
        {
            $response = Produk::join('table_kategori', 'table_produk.id_kategori','=','table_kategori.id_kategori')->join('table_suplier', 'table_suplier.id_suplier', '=', 'table_produk.id_suplier')->get(['table_produk.*', 'table_kategori.nama_kategori', 'table_suplier.nama_suplier']);
            return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $response])->setStatusCode(200);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       
    }


}