<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Users;
use Firebase\JWT\JWT;
use App\Models\Role;

class AuthController extends Controller
{
        private function jwt(Users $user) {
            $payload = [
                'iat' => intval(microtime(true)),        
                'uid' => $user->id,                      
                'exp' => intval(microtime(true)) + ( 60 * 60 * 1000)
            ];
            return JWT::encode($payload, env('JWT_SECRET'),'HS256');
    }

        public function login(Request $request) {
            $this->validate($request, [
            'username'     => 'required',
            'password'  => 'required'
        ]);

        // Find the user by email
        $user = Users::where('username', $request->input('username'))->first();
        if (!$user) {
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }
        // Verify the password and generate the token
        if (password_verify($request->input('password'), $user->password)) {
            return response()->json(['headers' => ["process_time" => microtime(), "messages"=> "Your request has been processed successfully"],
                'data' => ["token" => $this->jwt($user)]
            ], 200);
        }
        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }


    public function register(Request $request){

        $validate = $this->validate($request, [
            'is_admin' => 'required',
            'mobile_number' => 'required|numeric',
            'email' => 'required',
            'username' => 'required',
            'auth_type' => 'required',
            'password' => 'required',
            'remember_token' => 'required',
            'status' => 'required'

        ]);
      
            $post = new Users();
            $post->is_admin = $validate['is_admin'];
            $post->mobile_number = $validate['mobile_number'];
            $post->email = $validate['email'];
            $post->username = $validate['username'];
            $post->auth_type = $validate['auth_type'];
            $post->password = password_hash($validate['password'], PASSWORD_DEFAULT);
            $post->remember_token = $validate['remember_token'];
            $post->status = $validate['status'];
           
            $post->deleted_by = $request->deleted_by;
            $post->updated_by = $request->updated_by;
            $post->created_by = $request->created_by;
            // $role = Role::where('name', '=', strval($post->perms));
            // var_dump($role);
            $post->syncRoles([$request->perms]);
            $post->save();
            return response()->json(['headers' => 'created account is success', 'data' => $post])->setStatusCode(201);
    }
}
