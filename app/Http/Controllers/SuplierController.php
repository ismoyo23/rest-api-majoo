<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supliers;

class SuplierController extends Controller
{

    function __construct()
    {
         $this->middleware('role:admin');
    }
    
    public function index(){
        try
        {
            $response = Supliers::get();
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
                
                    'nama_suplier' => 'required',
                    'telp' => 'required|numeric',
                ]);
        
                $post = new Supliers;
                $post->nama_suplier = $validate['nama_suplier'];
                $post->telp = $validate['telp'];
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
            Supliers::where('id_suplier',$id)->delete();

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
            $response = Supliers::where('id_suplier', '=', $id)->get();
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
                'nama_suplier' => 'required',
                'telp' => 'required'
            ]);
            Supliers::where('id_suplier', $id)->update([
    
                    'nama_suplier' => $validate['nama_suplier'],
                    'telp' => $validate['telp'],
  
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