<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function store(Request $request, $id)
    {
        $fields = $request->validate([
            'file' => 'required',
            'file.*' => 'image|mimes:jpg,jpeg,png,docx,pdf,pptx|max:2000'
        ]);
        $assignment_id = $id;
        $users_id = Auth::User()->id;
        $students_id = Students::where('user_id', $users_id)->first()->id;
        if ($request->file('file')) {
            $file_sub = $request->file('file')->store('Submission');
            Submission::firstOrCreate([
                'student_id' => $students_id],
                ['assignment_id' => $assignment_id,
                'file' => $file_sub]
            );
            return response([
                'message' => 'submission Berhasil'
            ], 201);
        }
        return response([
            'message' => 'submission gagal'
        ], 401);
    }
}
