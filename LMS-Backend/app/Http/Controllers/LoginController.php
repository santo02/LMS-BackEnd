<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Students;
use App\Models\Theacers;
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
        $students = Students::where('email',  $fields['email'])->first();
        $Theacer = Theacers::where('email',  $fields['email'])->first();

        // check password
        if ($students && Hash::check($fields['password'], $students->password)) {
            $token = $students->createToken('myapptoken')->plainTextToken;
            $response = [
                'user' => $students,
                'token' => $token
            ];
            return response($response, 201);

        }elseif ($Theacer && Hash::check($fields['password'], $Theacer->password)) {
            $token = $Theacer->createToken('myapptoken')->plainTextToken;
            $response = [
                'user' => $Theacer,
                'token' => $token
            ];
            return response($response, 201);
            
        } else {
            return response([
                'message' => 'Login Failed',
            ], 401);
        }
    }
}
