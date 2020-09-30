<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    public function index()
    {
        return $this->user
            ->courses()
            ->get(['course_name', 'course_code', 'credit'])
            ->toArray();
    }
    public function show($id)
    {
        $courses = $this->user->courses()->find($id);

        if (!$courses) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Course with id ' . $id . ' cannot be found'
            ], 400);
        }

        return $courses;
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'course_name' => 'required',
            'course_code' => 'required',
            'credit' => 'required'
        ]);

        $course = new Course();
        $course->course_name = $request-> course_name;
        $course-> course_code = $request-> course_code;
         $course-> credit      = $request-> credit;

        if ($this->user->courses()->save($course))
            return response()->json([
                'success' => true,
                'student' => $course
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Course could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $course = $this->user->courses()->find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Course with id ' . $id . ' cannot be found'
            ], 400);
        }

        $updated = $course->fill($request->all())
            ->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, Course could not be updated'
            ], 500);
        }
    }
    public function destroy($id)
    {
        $course = $this->user->course()->find($id);

        if (!$course) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, course with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($course->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Course could not be deleted'
            ], 500);
        }
    }

}
