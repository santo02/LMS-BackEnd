<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;
use App\Models\Theacers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show()
    {
        $users_id = Auth::User()->id;
        $role = User::where('id', $users_id)->first()->role;

        if ($role == 'siswa') {
            $user = Students::join('users', 'users.id', '=', 'students.user_id')
            ->where('students.user_id', $users_id)
            ->select('users.name', 'students.NIS', 'users.email', 'students.phone', 'students.address')
            ->get();
        }
        elseif($role == 'guru'){
            $user = Theacers::join('users', 'users.id', '=', 'theacers.user_id')
            ->where('theacers.user_id', $users_id)
            ->select('users.name', 'theacers.NIP', 'users.email', 'theacers.phone', 'theacers.address')
            ->get();
        }
        return response([
            'user' => $user
        ],201);
    }
    public function update_profile(){
     
    }
}
