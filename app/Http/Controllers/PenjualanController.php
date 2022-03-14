<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use DB;

class PenjualanController extends Controller
{

    function __construct()
    {
         $this->middleware('role:admin|user');
    }

// penjualan per produk
    public function index(){
        try
        {
           $response = Penjualan::select('table_penjualan.id_produk', 'table_produk.name_produk', 'table_produk.harga', 'table_produk.diskripsi', DB::raw("COUNT(table_produk.name_produk) as count_produk"))->join('table_produk', 'table_penjualan.id_produk','=','table_produk.produk_id')->join('users', 'users.id', '=', 'table_penjualan.id')->groupBy("id_produk", 'table_produk.name_produk', 'table_produk.name_produk', 'table_produk.harga',  'table_produk.diskripsi')->get();
            return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $response])->setStatusCode(200);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       
    }

    // penjualan per produk
    public function laporanPenjualan(){
        try
        {
           $response = Penjualan::join('table_produk', 'table_penjualan.id_produk','=','table_produk.produk_id')->join('users', 'users.id', '=', 'table_penjualan.id')->get(['id_produk','table_produk.name_produk', 'table_produk.name_produk', 'table_produk.harga', 'table_produk.diskripsi', 'table_penjualan.created_at', 'users.email']);
            return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $response])->setStatusCode(200);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       
    }

    public function create(Request $request){

        try
        {
                $validate = $this->validate($request, [
                
                    'id_produk' => 'required',
                    'id' => 'required',
                    'id_pelanggan' => 'required',
                ]);
        
                $post = new Penjualan;
                $post->id_produk = $validate['id_produk'];
                $post->id = $validate['id'];
                $post->id_pelanggan = $validate['id_pelanggan'];
                $post->save();
        
                return response()->json(['headers' => [ "messages"=> "Data activity created"], 'data' => $validate])->setStatusCode(201);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       

    }

    public function deleted($id){
        try
        {
            Permission::where('id',$id)->delete();

            return response()->json(['headers' => [ "messages"=> "Data activity created"], 'data' => $id])->setStatusCode(201);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       
    }


    public function show($id){
        try
        {
            $response = Permission::where('id', '=', $id)->get();
            return response()->json(['headers' => [ "messages"=> "Your request has been processed successfully"], 'data' => $response])->setStatusCode(201);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
    }

    public function update(Request $request,$id){

        try
        {
            $validate = $this->validate($request, [
                'name' => 'required',
                'guard_name' => 'required'
            ]);
            Permission::where('id', $id)->update([
    
                    'name' => $validate['name'],
                    'guard_name' => $validate['guard_name'],
                    'created_at' => $request->created_at,
                    'updated_at'=>  $request->updated_at,
                    'deleted_at' => $request->deleted_at,
                    'created_by' => $request->created_by,
                    'updated_by' => $request->updated_by,
                    'deleted_by' => $request->deleted_by,
            ]);
    
            return response()->json(['headers' => [ "messages"=> "Your request has been processed successfully"], 'data' => $request])->setStatusCode(201);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       
    }
}