<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function store(Request $request){
        $request->validate([
            "title"=>"required|string|max:200",
             "description"=>"nullable|string",
        ]);
        
      $course = Course::create([
        "title" => $request->title,
        "description" => $request->description,
        "teacher_id" => $request->user()->id, 
    ]);
        return response()->json($course,201);
    }

    public function index(){
        $courses=Course::with("teacher")->get();
        return response()->json($courses);
    }

    public function show($id){
        $course=Course::with("teacher")->findOrFail($id);
        return response()->json($course);
    }

    public function update(Request $request, $id){
        $course=Course::findOrFail($id);
        $course->update($request->all());
        return response()->json($course);

    }
    public function destroy($id){
        $course=Course::findOrFail($id);
        $course->delete();
        return response()->json(["message"=>"Cours supprimé"]);
    }

}
