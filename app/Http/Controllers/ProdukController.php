<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use DB;

class ProdukController extends Controller
{

    function __construct()
    {
         $this->middleware('role:admin|user');
    }

     public function update(Request $request,$id){
        try
        {
            $validate = $this->validate($request, [
                'id_kategori' => 'required',
                'name_produk' => 'required',
                'harga' => 'required|numeric',
                'image' => 'required',
                'diskripsi' => 'required',
                'id_suplier' => 'required'
            ]);
            Produk::where('produk_id', $id)->update([
                    'id_kategori' => $validate['id_kategori'],
                    'name_produk' => $validate['name_produk'],
                    'harga' => $validate['harga'],
                    'image' => $validate['image'],
                    'diskripsi'=>  $validate['diskripsi'],
                    'id_suplier' => $validate['id_suplier'],
                    
            ]);

          
    
            return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $id])->setStatusCode(201);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       
    }

    
    public function index(Request $request,$id){
        try
        {
            if ($request->input('page') == "") {
             $response = Produk::join('table_kategori', 'table_produk.id_kategori','=','table_kategori.id_kategori')->join('table_suplier', 'table_suplier.id_suplier', '=', 'table_produk.id_suplier')->where('table_kategori.id_kategori', '=', $id)->get(['table_produk.*', 'table_kategori.nama_kategori', 'table_suplier.nama_suplier']);
                return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $response])->setStatusCode(200);
            }else{
                 $response = Produk::join('table_kategori', 'table_produk.id_kategori','=','table_kategori.id_kategori')->join('table_suplier', 'table_suplier.id_suplier', '=', 'table_produk.id_suplier')->where('table_kategori.id_kategori', '=', $id)->offset($request->input('page'))->limit(10)->get(['table_produk.*', 'table_kategori.nama_kategori', 'table_suplier.nama_suplier']);
                return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $response])->setStatusCode(200);
            }

           
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       
    }


    public function count_produk($id){
          $response = Produk::select('table_produk.name_produk')->where('id_kategori', '=', $id)->count();
          return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $response])->setStatusCode(200);
    
    }

    public function create(Request $request){

        try
        {
                $validate = $this->validate($request, [
                    'id_kategori' => 'required',
                    'name_produk' => 'required | unique:table_produk',
                    'harga' => 'required',
                    'image' => 'required',
                    'diskripsi' => 'required',
                    'id_suplier' => 'required'
                ]);
        
                $post = new Produk;
                $post->id_kategori = $validate['id_kategori'];
                $post->name_produk = $validate['name_produk'];
                $post->harga = $validate['harga'];
                $post->image = $validate['image'];
                $post->diskripsi = $validate['diskripsi'];
                $post->id_suplier = $validate['id_suplier'];
                $post->save();
        
                return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $post])->setStatusCode(201);
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
            Produk::where('produk_id',$id)->delete();

            return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $id])->setStatusCode(200);
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
            $response = Produk::join('table_kategori', 'table_produk.id_kategori','=','table_kategori.id_kategori')->join('table_suplier', 'table_suplier.id_suplier', '=', 'table_produk.id_suplier')->where('table_produk.produk_id', '=', $id)->get(['table_produk.*', 'table_kategori.nama_kategori', 'table_suplier.nama_suplier']);
            return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $response])->setStatusCode(200);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
    }

   
}