<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Models\Mark;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Redirect;
class StudentController extends Controller
{


 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $student=new Student;
        $student->name=$request->name;

        $student->gender=$request->gender;
        $student->age=$request->age;
        $teacher = Teacher::find($request->reporting_teacher);
        $student->teacher()->associate($teacher); 

        if ($student->save()) {
           
            $students=Student::all();

            return Redirect::back()->with([
                'data' =>$students,
            ]);

        } else {
            return Redirect::route('dashboard');
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudentRequest $request)
    {
        //
    }
    /**
     * Add mark a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function addMark(Request $request)
    {
       $subjects=$request->except(['student','term']);
       $student=Student::find($request->student);
       $isexist=$student->marks()->where('term',$request->term)->get();

       if (!empty($isexist)) {
        $student->marks()->where('term',$request->term)->delete();
       }

       foreach ($subjects as $id => $markvalue) {

        
     $mark=new Mark;
     $subject=Subject::find($id);
     $mark->student()->associate($student);
     $mark->subject()->associate($subject);
     $mark->mark=$markvalue;
     $mark->term=$request->term;
     $mark->save();

   


       }


       $students=Student::all();

       return Redirect::back()->with([
           'data' =>$students,
       ]);

    }

    public function editMark(Request $request)
    {
       $subjects=$request->except(['student','term']);
       $student=Student::find($request->student);
       $isexist=$student->marks()->where('term',$request->term)->get();

       if (!empty($isexist)) {
        $student->marks()->delete();

       } else {
        $student->marks()->delete();

       }

       foreach ($subjects as $id => $markvalue) {

        
     $mark=new Mark;
     $subject=Subject::find($id);
     $mark->student()->associate($student);
     $mark->subject()->associate($subject);
     $mark->mark=$markvalue;
     $mark->term=$request->term;
     $mark->save();

   


       }


       $students=Student::all();

       return Redirect::back()->with([
           'data' =>$students,
       ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStudentRequest  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $student= Student::find($request->id);
        $student->name=$request->name;

        $student->gender=$request->gender;
        $student->age=$request->age;
        $teacher = Teacher::find($request->teacher_id);
        $student->teacher()->associate($teacher); 

        if ($student->save()) {
           
            $students=Student::all();

            return Redirect::back()->with([
                'data' =>$students,
            ]);

        } else {
            return Redirect::route('dashboard');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       
        if (Student::find($request->id)->delete()) {
           
            $students=Student::all();

            return Redirect::back()->with([
                'data' =>$students,
            ]);

        }
        else {
            return Redirect::route('dashboard');
        }
    }

    public function deleteMarks(Request $request)
    {
        $student=Student::find($request->id);
       
         $student->marks()->where('term',$request->term)->delete();
        
    }
}
