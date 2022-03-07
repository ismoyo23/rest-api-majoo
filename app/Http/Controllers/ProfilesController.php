<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profiles;

class ProfilesController extends Controller
{
    public function index(){
        try
        {
            $response = Permission::get();
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
                
                    'guard_name' => 'required',
                    'name' => 'required',
                ]);
        
                $post = new Permission;
                $post->name = $validate['name'];
                $post->guard_name = $validate['guard_name'];
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