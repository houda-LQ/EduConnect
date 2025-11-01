<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
   public function enroll(Request $request, $course_id)
{
    $user = $request->user(); 

    $course = Course::findOrFail($course_id);

    if ($course->students()->where('user_id', $user->id)->exists()) {
        return response()->json(['message' => 'Déjà inscrit à ce cours'], 400);
    }

    $course->students()->attach($user->id);

    return response()->json(['message' => 'Inscription réussie !']);
}


 public function myCourses($user_id)
    {
        $user = User::with('coursesEnrolled')->findOrFail($user_id);

        return response()->json([
            'user' => $user->name,
            'courses' => $user->coursesEnrolled
        ]);
    }
}



