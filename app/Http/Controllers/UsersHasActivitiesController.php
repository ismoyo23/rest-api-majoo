<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersHasActivity;

class UsersHasActivitiesController extends Controller
{
    public function index(){
        try
        {
            $response = usersHasActivity::join('users', 'user_has_activity.users_id', '=', 'users.id')->join('activities', 'user_has_activity.activity_id','=','activities.id')->get('users.is_admin', 'users.mobile_number', 'users.username', 'users.auth_type', 'users_has_activity.name', 'users_has_activity.access_type', 'users_has_activity.ip_address', 'users_has_activity.latitude', 'users_has_activity.longitude', 'activities.name as name_activities', 'activities.email');
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
                
                    'user_id' => 'required',
                    'activity_id' => 'required',
                    'name' => 'required',
                    'acccess_type' => 'required',
                    'ip_address' => 'required',
                    'latitude' => 'required',
                    'longitude' => 'required',
            
                ]);
        
                $post = new usersHasActivity;
                $post->user_id = $validate['user_id'];
                $post->activity_id = $validate['activity_id'];
                $post->name = $validate['name'];
                $post->access_type = $validate['access_type'];
                $post->ip_address = $validate['ip_address'];
                $post->latitude = $validate['latitude'];
                $post->longitude = $validate['longitude'];
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
            usersHasActivity::where('id',$id)->delete();

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
            $response = usersHasActivity::where('id', '=', $id)->get();
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
                
                'user_id' => 'required',
                'activity_id' => 'required',
                'name' => 'required',
                'acccess_type' => 'required',
                'ip_address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
        
            ]);
            userHasActivity::where('id', $id)->update([
    
                    $post->user_id = $validate['user_id'],
                    $post->activity_id = $validate['activity_id'],
                    $post->name = $validate['name'],
                    $post->access_type = $validate['access_type'],
                    $post->ip_address = $validate['ip_address'],
                    $post->latitude = $validate['latitude'],
                    $post->longitude = $validate['longitude'],
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