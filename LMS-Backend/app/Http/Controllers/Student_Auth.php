<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Student_Auth extends Controller
{
    public function Register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:20',
            'NIS' => 'required|string|unique:students',
            'phone' => 'required|string',
            'email' => 'required|string|unique:users',
            'address' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'username' => $fields['username'],
            'password' => bcrypt($fields['password']),
            'role' => "siswa"
        ]);

        $id = DB::table('users')->orderBy('id', 'DESC')->limit(1)->get();
        foreach($id as $i){
            $id_user = $i->id; 
        }

        $student = Students::create([
            'user_id' => $id_user,
            'NIS' => $fields['NIS'],
            'phone' => $fields['phone'],
            'address' => $fields['address']
        ]);

        $token = $student->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $student,
            'token' => $token
        ];
        
        return response($response, 201);
    }

    public function index(){
        $data = DB::table('students')
        ->join('users', 'user_id', '=', 'users.id')
        ->select('users.name','users.email', 'students.NIS', 'students.phone', 'students.address')
        ->get();

        $response = [
            'user' => $data
        ];

        return response($response, 201);
    }

    public function delete($id){
        User::destroy($id);

        $response = [
            'message' => "Berhasil dihapus"
        ];
        return response($response, 201);
    }
}
