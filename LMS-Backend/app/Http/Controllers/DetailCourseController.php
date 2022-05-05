<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailCourseController extends Controller
{
  
    public function index(Request $request, $id)
    {
        $theachers_id = Auth::User()->id;
        $course = DB::table('courses')->where('id', $id);
        $theachers = DB::table('users')->where('id', $theachers_id)->get('name');
        return response([
            'theachers' => $theachers,
            'course_id' => $course->get('id'),
            'course_name' => $course->get('title'),
        ]);
    }
}
