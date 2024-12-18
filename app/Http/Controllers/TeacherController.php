<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Enums\Role;
use PhpParser\Node\Stmt\TryCatch;

class TeacherController extends Controller
{
    public function getProfile(){
        $id = request()->query('teacherId');
            return view('teachersprofile', [
            "teacher" => Teacher::dataWithId($id)
        ]);
    }

    public function teachersListView () {
        $id = request()->query('schoolId');
        if($id==null){
            return view('teachers', [
                "state" => "teachers list",
                "teachers" => Teacher::all()
            ]);
        }else{
            return view('teachers', [
            "state" => "teachers list with school",
            "teachers" => Teacher::dataWithSchoolId($id),
            "school" => School::dataWithId($id)
            ]);
        }
    }
}
