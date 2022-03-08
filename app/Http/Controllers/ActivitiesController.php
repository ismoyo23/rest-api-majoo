<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activities;

class ActivitiesController extends Controller
{

    function __construct()
    {
         $this->middleware('role:admin|user');
    }
    public function index(){
        try
        {
            $response = Activities::join('permissions', 'activities.permission_id','=','permissions.id')->get(['permissions.guard_name', 'activities.*']);
            return response()->json(['headers' => [ "messages"=> "Your request has been processed successfully"], 'data' => $response])->setStatusCode(200);
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
                    'permission_id' => 'required',
                    'name' => 'required',
                    'email' => 'required'
                ]);
        
                $post = new Activities;
                $post->permission_id = $validate['permission_id'];
                $post->name = $validate['name'];
                $post->email = $validate['email'];
                $post->created_by = $request->created_by;
                $post->updated_by = $request->updated_by;
                $post->deleted_by = $request->deleted_by;
                $post->save();
        
                return response()->json(['headers' => [ "messages"=> "Data activity created"], 'data' => $request])->setStatusCode(201);
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
            User::where('id',$id)->delete();

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
            $response = Activities::join('permission', 'activities.permission_id','=','permission.id')->where('id', '=', $id)->get(['permission.guard_name', 'activities.*']);
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
                'permission_id' => 'required',
                'name' => 'required',
                'email' => 'required'
            ]);
            Student::where('id', $id)->update([
                    'permission_id' => $validate['permission_id'],
                    'name' => $validate['name'],
                    'email' => $validate['email'],
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