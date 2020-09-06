<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Kk;
use App\clss;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getAllStudents() {
        $students = Student::get()->toJson(JSON_PRETTY_PRINT);
        return response($students, 200);
      }

    public function createStudent(Request $request) {
    $student = new Student;
    $student->name = $request->name;
    $student->course = $request->course;
    $student->save();

    return response()->json([
        "message" => "student record created"
    ], 201);
    }

    public function getStudent($id) {
    if (Student::where('id', $id)->exists()) {
        $student = Student::where('id', $id)->firstOrfail()->toJson(JSON_PRETTY_PRINT);
        return response($student, 200);
        } else {
         //   return  abort(404);
       return response()->json([
            "message" => "Student not found"
        ], 404);

        }

     /*   $student = Student::where('id', $id)->firstOrfail()->toJson(JSON_PRETTY_PRINT);
        return response($student, 200);*/
    }

    public function updateStudent(Request $request, $id) {
    if (Student::where('id', $id)->exists()) {
        $student = Student::find($id);
        $student->name = is_null($request->name) ? $student->name : $request->name;
        $student->course = is_null($request->course) ? $student->course : $request->course;
        $student->save();

        return response()->json([
            "message" => "records updated successfully"
        ], 200);
        } else {
        return response()->json([
            "message" => "Student not found"
        ], 404);

    }
}

public function deleteStudent ($id) {
    if(Student::where('id', $id)->exists()) {
        $student = Student::find($id);
        $student->delete();

        return response()->json([
        "message" => "records deleted"
        ], 202);
    } else {
        return response()->json([
        "message" => "Student not found"
        ], 404);
    }
    }
    public function controller2 () {


    $dd =DB::table('students')
    ->join('kks', function ($join) {
        $join->on('students.id', '=', 'kks.cled')
             ->where('kks.cled', '>', 2);
    })
    ->select('kks.*')
    ->get();
    // logic to delete a student record goes here


    return response()->json([
        "message" => $dd
    ], 201);


}

        public function controller3 ($idjoin,$idjoin2) {

            $clss = clss::where('id', $idjoin2)
            ->where('student_id', $idjoin)
            ->firstOrfail()->toJson(JSON_PRETTY_PRINT);
            return response($clss, 200);

            }

        public function controller4 (Request $request,$id ) {
            $student = Student::find($id);


            $clss1 = new clss();
            $clss1->num = $request->num;
            $clss1->student_id = $student->id;
            $clss1->save();

            return response()->json([
                "message" => "clss record created"
            ], 201);
            }
}
