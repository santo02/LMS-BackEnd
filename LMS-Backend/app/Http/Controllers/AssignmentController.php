<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Theacers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function store(Request $request, $id){
        $users_id = Auth::User()->id;
        $theacher_id = Theacers::where('user_id', $users_id)->first()->id;

        $fields = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'deadline' => 'required|date|date_format:Y-m-d',
            'file.*' => 'image|mimes:jpg,jpeg,png,docx,pdf,pptx|max:2000'
        ]);

        if ($request->file('file')) {
            $file_assg = $request->file('file')->store('assignment');
            Assignment::create([
                'theacher_id' => $theacher_id,
                'title' => $fields['title'],
                'description' => $fields['description'],
                'deadline' => $fields['deadline'],
                'course_id' => $id,
                'file' => $file_assg
            ]);
            return response([
                'message' => 'Berhasil'
            ], 201);
        }
        return response([
            'message' => 'failed'
        ], 401);
    }

    public function update(Request $request, $id)
    {
        $users_id = Auth::User()->id;
        $theacher_id = Theacers::where('user_id', $users_id)->first()->id;
        $Ass = Assignment::find($id);
        $Ass->title = $request->title;
        $Ass->description = $request->description;
        $Ass->deadline = $request->deadline;
        $Ass->file = $request->file;
        $Ass->theacher_id = $theacher_id;
        $Ass->save();
        return $Ass;
    }
    public function delete($id)
    {
        $data = Assignment::find($id);
        if (is_null($data)) {
            $response = [
                'message' => "Data not found"
            ];
            return response($response, 201);
        }
        Assignment::destroy($id);
        $response = [
            'message' => "Assignment has been delete"
        ];
        return response($response, 201);
    }

    public function detail_assignment($id){
        $guru = Assignment::where('id', $id)
        ->first()->theacher_id;
        $user = Theacers::where('id', $guru)->first()->user_id;
        $name_theac = User::where('id', $user)->get('name');

        $assignment = Assignment::join('courses', 'courses.id', '=', 'assignments.course_id')
        ->select('courses.title')
        ->select('assignments.title', 'assignments.description', 'assignments.file', 'assignments.deadline')
        ->get();

        return response([
            'Nama guru' => $name_theac,
            'materi' => $assignment
        ],201);

    }
}

