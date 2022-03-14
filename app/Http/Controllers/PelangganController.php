<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{

    function __construct()
    {
         $this->middleware('role:admin|user');
    }

    public function index(){
        try
        {
            $response = Pelanggan::get();
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
                   'nama_pelanggan' => 'required',
                   'no_pelanggan' => 'required',
                   'alamat' => 'required'
                ]);
        
                $post = new Pelanggan;
                $post->nama_pelanggan = $validate['nama_pelanggan'];
                $post->no_pelanggan = $validate['no_pelanggan'];
                $post->alamat = $validate['alamat'];
                $post->save();
        
                return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $post])->setStatusCode(201);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       

    }

    public function delete($id){
        try
        {
            Pelanggan::where('id_pelanggan',$id)->delete();

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
            $response = Pelanggan::where('id_pelanggan', $id)->get();
            return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $response])->setStatusCode(200);
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
                   'nama_pelanggan' => 'required',
                   'no_pelanggan' => 'required',
                   'alamat' => 'required'
                ]);
            Pelanggan::where('id_pelanggan', $id)->update([
                    'nama_pelanggan' => $validate['nama_pelanggan'],
                    'no_pelanggan' => $validate['no_pelanggan'],
                    'alamat' => $validate['alamat'],
                    
            ]);

          
    
            return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $id])->setStatusCode(201);
        }
        catch(Exception $e)
        {
            // This doesn't work. This code is never called because Laravel 
            return $this->setStatusCode(505)->respondWithError($e);
        }
       
    }
   
}


  