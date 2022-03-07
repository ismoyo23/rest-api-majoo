<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;

class PermissionController extends Controller
{
    public function index(){
        try
        {
            $response = File::get();
            return response()->json(['headers' => [ "messages"=> "Your request has been processed successfully"], 'data' => $response])->setStatusCode(201);
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
                
                    'type' => 'required',
                    'full_name' => 'required',
                    'size' => 'required|number',
                ]);
        
                $post = new File;
                $post->full_name = $validate['full_name'];
                $post->type = $validate['type'];
                $post->size = $validate['size'];
                $post->created_by = $request->created_by;
                $post->updated_by = $request->updated_by;
                $post->deleted_by = $request->deleted_by;
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
            File::where('id',$id)->delete();

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
            $response = File::where('id', '=', $id)->get();
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
                'full_name' => 'required',
                'type' => 'required',
                'size' => 'required|number'
            ]);
            File::where('id', $id)->update([
    
                    'full_name' => $validate['full_name'],
                    'type' => $validate['type'],
                    'size' => $validate['size'],
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