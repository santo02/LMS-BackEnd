<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Theacers;
use Illuminate\Http\Request;

class Theacher_Auth extends Controller
{
    public function Register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string|max:20',
            'NIP' => 'required|string|unique:theacers',
            'phone' => 'required|string',
            'email' => 'required|string|unique:theacers',
            'address' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string|confirmed'

        ]);

        $Theacher = Theacers::create([
            'name' => $fields['name'],
            'NIP' => $fields['NIP'],
            'phone' => $fields['phone'],
            'email' => $fields['email'],
            'address' => $fields['address'],
            'username' => $fields['username'],
            'password' => bcrypt($fields['password']),
            'role' => "guru"
        ]);

        $token = $Theacher->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $Theacher,
            'token' => $token
        ];

        return response($response, 201);
    }
    
}
