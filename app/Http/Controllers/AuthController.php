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
            $validate = $this->validate($request, [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        // Find the user by email
        $user = Users::join('roles', 'roles.id', '=', 'users.id')->where('email', $request->input('email'))->first();
        if (!$user) {
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }
        // Verify the password and generate the token
        if (password_verify($request->input('password'), $user->password)) {
            return response()->json(['headers' => ["process_time" => microtime(), "messages"=> "Your request has been processed successfully"],
                'data' => ["token" => $this->jwt($user), "result" => $user]
            ], 200);
        }
        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }


    public function register(Request $request){

        $validate = $this->validate($request, [
            'telp' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
         
            'password' => 'required',
            'alamat' => 'required',


        ]);
      
            $post = new Users();
            $post->email = $validate['email'];
            $post->password = password_hash($validate['password'], PASSWORD_DEFAULT);
            $post->telp = $validate['telp'];
            $post->alamat = $validate['alamat'];
            $post->syncRoles([$request->perms]);
            $post->save();
            return response()->json(['headers' => 'created account is success', 'data' => $post])->setStatusCode(201);
    }


    public function user(){
        $response = Users::join('roles', 'roles.id', '=', 'users.id')->get(['roles.*', 'users.*']);
        return response()->json(['headers' => ["process_time" => microtime(),'message' =>'process data success'], 'data' => $response])->setStatusCode(200);
    }
}
