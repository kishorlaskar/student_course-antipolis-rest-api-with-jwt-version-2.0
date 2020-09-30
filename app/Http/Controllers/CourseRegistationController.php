<?php

namespace App\Http\Controllers;
use App\Courseregistation;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use App\Student;
use App\Course;
use App\User;

use Illuminate\Http\Request;

class CourseRegistationController extends Controller
{

    protected $user;
    protected $student;
    protected $course;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    public function index()
    {
        $regcourse = Courseregistation::all();
        return $regcourse;

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'course_fee' => 'required',
            'course_duration' => 'required',

        ]);
        $registation = new Courseregistation();
        $registation->student_id = $request->student_id;
        $registation->course_id = $request->course_id;
        $registation->course_fee = $request->course_fee;
        $registation->course_duration = $request->course_duration;

        $registation->save();
         return $registation;
    }

    public function drop($id)
    {
        $delete_category = Courseregistation::find($id);
        if (!$delete_category) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, course with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($delete_category->delete()) {
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

    public function student_course()
    {
        $student_course = DB::table('courseregistations')
            ->join('students','courseregistations.student_id','students.id')
            ->join('courses','courseregistations.student_id','students.id')
            ->where('courseregistations.student_id','=','students.id')
            ->select('courseregistations.id','students.name','courses.course_name')
            ->get();

            return $student_course;
    }

}
