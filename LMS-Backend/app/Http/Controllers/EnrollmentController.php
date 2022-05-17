<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\MyCourse;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\course;

class EnrollmentController extends Controller
{
    public function enroll_byteach(Request $request, $idc)
    {
        $fields = $request->validate([
            'NIS' => 'required|string',
            'name' => 'required|string',
        ]);

        $students = Students::where('NIS',  $fields['NIS'])->first();
        $students_name = User::where('name', $fields['name'])->first();
        if ($students && ($fields['name'] == $students_name->name)) {
            MyCourse::firstOrCreate(['student_id' => $students->id], ['course_id' => $idc]);
            return response([
                'message' => 'berhasil di enroll'
            ], 201);
        } else {
            return response([
                'message' => 'enroll gagal'
            ], 401);
        }
    }

    public function reset_enrollment($idc)
    {
        $data = MyCourse::where('course_id', '=', $idc);
        if (is_null($data)) {
            $response = [
                'message' => "Data not found"
            ];
            return response($response, 401);
        }
        MyCourse::where('course_id', '=', $idc)->delete();
        $response = [
            'message' => "Enrollment has been reset"
        ];
        return response($response, 201);
    }

    public function enroll(Request $request, $idc)
    {
        $fields = $request->validate([
            'enroll_key' => 'required|string',
        ]);

        $users_id = Auth::User()->id;
        $student_id = Students::where('user_id', $users_id)->first()->id;
        $course_id = $idc;
        $course = course::where('id', $course_id)->first();
        $data =  MyCourse::firstOrCreate(['course_id' => $course_id], ['student_id' => $student_id]);
        if ($fields['enroll_key'] == $course->enroll_key) {
            $data;
            return response([
                'message' => $data,
                'id_s' => $student_id
            ], 201);
        } elseif ($fields['enroll_key'] != $course->enroll_key) {
            return response([
                'message' => 'enroll key salah'
            ], 401);
        }
        return response([
            'message' => 'Gagal'
        ], 401);
    }
}
