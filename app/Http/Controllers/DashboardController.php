<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;

class DashboardController extends Controller
{
    //

public function render()
{

   $students=Student::orderBy('created_at', 'desc')->get();
   $teachers=Teacher::orderBy('created_at', 'desc')->get();
   $subjects=Subject::orderBy('created_at', 'desc')->get();
  $marklists=[];

foreach ($students as $student){
    $marklists[]=$student->marks()->where('term','One')->get();
    $marklists[]=$student->marks()->where('term','Two')->get();

 }



    return Inertia::render('Dashboard',['data'=>$students,'teachers'=>$teachers,'subjects'=>$subjects,'marklist'=>$marklists]);
}

    
}
