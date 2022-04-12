<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;

class Student_Auth extends Controller
{
    public function Register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:20',
            'NIS' => 'required|string|unique:students',
            'phone' => 'required|string',
            'email' => 'required|string|unique:students',
            'address' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string|confirmed'

        ]);
        $student = Students::create([
            'name' => $fields['name'],
            'NIS' => $fields['NIS'],
            'phone' => $fields['phone'],
            'email' => $fields['email'],
            'address' => $fields['address'],
            'username' => $fields['username'],
            'password' => bcrypt($fields['password']),
            'role' => "siswa"
        ]);

        $token = $student->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $student,
            'token' => $token
        ];

        return response($response, 201);
    }
}
