<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                "status"    => "error",
                "code"      => 400,
                "message"   => "Validation Error",
                "error"     => $validator->errors()
            ], 400);
        }

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
        Auth::user();
        
        return response()->json([
            "status"    => "success",
            "code"      => 200,
            "message"   => "Login Successfully"
        ], 200);
    
    } else {
        
        return response()->json([
            "status"    => "error",
            "code"      => 401,
            "message"   => "Login Failed"
        ], 401);
    
    }

        
    }
}
