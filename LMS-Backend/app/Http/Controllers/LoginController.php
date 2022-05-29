<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function Login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //    check email
        $User = User::where('email',  $fields['email'])->first();
              
        if ($User && Hash::check($fields['password'], $User->password)) {
            $token = $User->createToken('myapptoken')->plainTextToken;
            $response = [
                'message' => 'Login success',
                'user' => $User,
                'token' => $token
            ];
            
            return response($response, 200);
                    
        } else {
            return response([
                'message' => 'Login Failed',
            ], 401);
        }
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response([ 
            'message' => 'Logged out'
        ],200);
    }
    
}
