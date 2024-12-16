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
}
