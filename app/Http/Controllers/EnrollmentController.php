<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll(Request $request,$course_id){
        $request->validate([
            "user_id"=>"required|exists:users,id"
        ]);
        $enrollment=Enrollment::create([
            "user_id"=>$request->user_id,
            "course_id"=>$course_id
        ]);
        return response()->json($enrollment,201);
    }

    public function myCourses($user_id){
        $user=User::with("coursesEnrolled")->findOrFail($user_id);
        return response()->json($user->coursesEnrolled);
    }
}
