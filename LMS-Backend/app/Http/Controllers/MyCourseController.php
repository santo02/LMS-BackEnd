<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\course;
use App\Models\MyCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Students;

class MyCourseController extends Controller
{   
    public function myCourse(){
        $users_id = Auth::User()->id;
        $student_id = Students::where('user_id', $users_id)->first()->id;
        $MyCourse  = myCourse::join('courses', 'courses.id', '=', 'my_courses.course_id')
        ->where('my_courses.student_id', $student_id)
        ->select('courses.id','courses.title', 'courses.thumbnail','courses.deskripsi')
        ->get();
        return response([ 
            'course' => $MyCourse   
        ],201);
    }
}
