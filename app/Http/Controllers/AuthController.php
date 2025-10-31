<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        $request->validate([
            "name"=>"required|string|max:10",
            "email"=>"required|string|email|unique:users",
            "password"=>"required|string|min:8|confirmed",

        ]);
        $user=User::create([
            "name"=> $request->name,
            "email"=> $request->email,
            "password"=> Hash::make($request->password),

        ]);
        return response()->json(["message"=>"user registered successfully",
                                  "user"=>$user
    ],201);
    }


 public function login(Request $request){

         $request->validate([
            "email"=>"required|string|email",
            "password"=>"required|string",

        ]);
        if(!Auth::attempt($request->only("email","password")))
        return response()->json(
            [
                "message"=>"invalid"
            ],401
        );

        $user=User::where("email",$request->email)->FirstOrFail();
       $token= $user->createToken("auth_Token")->plainTextToken;

       return response()->json(["message"=>"user registered successfully",
                                  "user"=>$user,
                                  "token"=>$token
    ],201);
    }
    
    
    


     public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(["message"=>"logout successful",
                                
     ]);

    }

}
