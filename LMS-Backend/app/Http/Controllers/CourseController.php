<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\course;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $course = DB::table('courses')->get();

        if (is_null($course)) {
            $response = [
                'message' => "Data not found"
            ];
            return response($response, 201);
        }
        $response = [
            'course' => $course,
        ];
        return response($response, 201);
    }


    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:20',
            'thumbnail' => 'required',
            'thumbnail.*' => 'image|mimes:jpg,jpeg,png|max:2000',
            'jurusan' => 'required|string',
            'deskripsi' => 'required|string',
            'enroll_key' => 'required|string'
        ]);

        $theachers_id = Auth::User()->id;

        if ($request->file('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('thumbnail');
            course::create([
                'title' => $fields['title'],
                'thumbnail' => $thumbnail,
                'jurusan' => $fields['jurusan'],
                'deskripsi' => $fields['deskripsi'],
                'enroll_key' => $fields['enroll_key'],
                'theachers_id' => $theachers_id
            ]);
        }

        $response = [
            'message' => "succesfully"
        ];

        return response($response, 201);
    }


    public function delete($id)
    {
        $data = Course::find($id);
        if (is_null($data)) {
            $response = [
                'message' => "Data not found"
            ];
            return response($response, 201);
        }
        Course::destroy($id);
        $response = [
            'message' => "Course has been delete"
        ];
        return response($response, 201);
    }


    public function Update(Request $request,  $id)
    {
        $theachers_id = Auth::User()->id;
        $course = course::find($id);
        $course->title = $request->title;
        $course->thumbnail = $request->thumbnail;
        $course->jurusan = $request->jurusan;
        $course->deskripsi = $request->deskripsi;
        $course->enroll_key = $request->enroll_key;
        $course->theachers_id = $theachers_id;
        $course->save();
        
        return $course;
    }
}
