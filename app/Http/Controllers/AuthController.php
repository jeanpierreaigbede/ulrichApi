<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class AuthController extends Controller
{


    public function register(Request $request){

        $input = $request->all();

        $validator = Validator::make($input,
        [
            'shop' => 'required|string',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()){
            return $validator->errors();
        }
        else{
            $user = User::create([
                'shop' => $request->shop,
                'phone' => $request->phone,
                'password' =>bcrypt($request->password)

            ]);
            $token = $user->createToken('myToken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response,200);
        }

    }

    // LOGIN

    public function login(Request $request){
        $input = $request->all();
        $validator = $request->validate(
         [
            'phone' => 'required',
            'password' => 'required|string|min:6'
            ]);

        
        $user = User::where('phone',$validator['phone'])->first();

        // check password

        if(!$user || !Hash::check($validator['password'],$user->password))
        {
            return response([
                'message' => "Bad reds"
            ], 
            401);
        }

        else {
            $token = $user->createToken('myToken')->plainTextToken;

        $response = [
            'message' => "Connected successfully",
            'user' => $user,
            'token' => $token,
        ];

        return response($response,200);
        }
    }

        // LOGOUT
        public function logout($id){
        
        $user= User::find($id);
        $user->tokens()->delete();
            return response([
                'message' => " logged out"
            ]);
        }

    
}
