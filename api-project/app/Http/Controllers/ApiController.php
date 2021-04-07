<?php

namespace App\Http\Controllers;

use App\Models\Student;
use http\Env\Response;
use Illuminate\Http\Request;



class ApiController extends Controller
{
    public function getAllStudents(Request $request) {

        $student = Student::get()->toJson(JSON_PRETTY_PRINT);
        return response($student,200);

    }

    public function createStudent(Request $request) {
        $student = new Student;
        $student->name = $request->name;
        $student->course = $request->course;
        $student->save();

        return response()->json(["message"=>"The record has been created"],201);
    }

    public function getStudent($id) {
        if (Student::where('id',$id)->exists()){
            $student = Student::where('id',$id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($student,200);
        }
        else{
            return response()->json(["No records found"],404);
        }

    }

    public function updateStudent(Request $request, $id) {
        if(Student::where('id',$id)->exists()){
            $student = Student::find($id);
            $student->name = is_null($request->name)? $student->name : $request->name;
            $student->course = is_null($request->course) ? $student->course : $request->course;

            $student->save();
            return response()->json(["message"=>"its updated"],200);
        }
        else{
            return response()->json(['message'=>'No cards found'],404);
        }
    }

    public function deleteStudent ($id) {
        if(Student:: where('id',$id)->exists()){
            $student = Student::find($id);
            $student->delete();
            return response()->json(["message"=>"Your record has been deleted"],202);
        }
        else{
            return response()->json(["message"=>"No such record found"],404);
        }
    }
}
