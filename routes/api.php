<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\UserController;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::post("/courses", [CourseController::class,"store"]);
// Route::get("/courses/liste", [CourseController::class,"index"]);
// Route::get("/courses/{id}/details", [CourseController::class,"show"]);
// Route::put("/courses/{id}/update", [CourseController::class,"update"]);
// Route::delete("/courses/{id}", [CourseController::class,"destroy"]);

// Route::post("/courses/{id}/enroll", [EnrollmentController::class,"enroll"]);
// Route::get("/my-courses/{user_id}", [EnrollmentController::class,"myCourses"]);


// Route::get('/users', [UserController::class, 'index']);
// Route::post('/users', [UserController::class, 'store']);
// Route::put('/users/{id}/update', [UserController::class, 'update']);
// Route::delete('/users/{id}', [UserController::class, 'destroy']);



// Route::post("register",[AuthController::class,"register"]);
// Route::post("login",[AuthController::class,"login"]);
// Route::post("logout",[AuthController::class,"logout"])->middleware('auth:sanctum');



Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);
Route::post("logout", [AuthController::class, "logout"])->middleware('auth:sanctum');



Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
    Route::post("/courses", [CourseController::class, "store"]);
    Route::put("/courses/{id}/update", [CourseController::class, "update"]);
    Route::delete("/courses/{id}", [CourseController::class, "destroy"]);
});


Route::middleware(['auth:sanctum', 'role:student'])->group(function () {
    Route::post("/courses/{id}/enroll", [EnrollmentController::class, "enroll"]);
    Route::get("/my-courses/{user_id}", [EnrollmentController::class, "myCourses"]);
});


Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}/update', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});


Route::get("/courses/liste", [CourseController::class, "index"]);
Route::get("/courses/{id}/details", [CourseController::class, "show"]);
