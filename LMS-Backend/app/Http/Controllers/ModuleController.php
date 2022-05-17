<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DetailCourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\course;
use App\Models\Module;
use Error;

class ModuleController extends Controller
{

    public function store(Request $request, $id)
    {
        $fields = $request->validate([
            'topic' => 'required|string',
            'content' => 'required|string',
            'week' => 'required|string',
            'sesion' => 'required|string',
            'sesion_date' => 'required|date|date_format:Y-m-d',
            'file' => 'required',
            'file.*' => 'image|mimes:jpg,jpeg,png,docx,pdf,pptx|max:2000'
        ]);

        $course_id = $id;
        if ($request->file('file')) {
            $file_module = $request->file('file')->store('modules');
            Module::create([
                'course_id' => $course_id,
                'topic' => $fields['topic'],
                'content' => $fields['content'],
                'week' => $fields['week'],
                'sesion' => $fields['sesion'],
                'sesison_date' => $fields['sesion_date'],
                'file' => $file_module
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
        // $module = DB::table('Modules')->where('module_id', $id);
        
        $module = Module::where('module_id', '=', $id);
        $module->update(
            $request->all()
        );
        
        $response = [
            'message' => "Module has been update"
        ];
        return response($response, 201);
    }

    public function destroy($id)
    {

        $delete_modules = DB::table('Modules')->where('module_id', $id)->delete();
        if ($delete_modules) {
            $response = [
                'message' => "Module has been delete"
            ];
            return response($response, 201);
        }
        else{
            $response = [
                'message' => "Delete failed"
            ];
            return response($response, 401);
        }
    }
}
