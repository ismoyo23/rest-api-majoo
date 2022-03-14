<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{

    function __construct()
    {
         $this->middleware('role:admin|user');
    }
    public function index(){
        try
        {
            $response = Kategori::get();
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
                    'nama_kategori' => 'required',
                ]);
        
                $post = new Kategori;
                $post->nama_kategori = $validate['nama_kategori'];
            
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
            Kategori::where('id_kategori',$id)->delete();

            return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $id])->setStatusCode(200);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       
    }



}