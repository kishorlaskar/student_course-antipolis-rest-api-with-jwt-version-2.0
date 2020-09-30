<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Student;
use Illuminate\Http\Request;



class StudentController extends Controller
{
    protected $user;


    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    public function index()
    {
        return $this->user
            ->students()
            ->get(['name', 'email', 'semester'])
            ->toArray();
    }
    public function show($id)
    {
        $student = $this->user->students()->find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, student with id ' . $id . ' cannot be found'
            ], 400);
        }

        return $student;
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'semester' => 'required'
        ]);

        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->semester = $request->semester;

        if ($this->user->students()->save($student))
            return response()->json([
                'success' => true,
                'student' => $student
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Sorry, student could not be added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $student = $this->user->students()->find($id);

        if (!$student)
        {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, student with id ' . $id . ' cannot be found'
            ], 400);
        }

        $updated = $student->fill($request->all())
            ->save();

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, student could not be updated'
            ], 500);
        }
    }



}
