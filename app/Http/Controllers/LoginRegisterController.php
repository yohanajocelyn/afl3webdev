<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class LoginRegisterController extends Controller
{
    public function logRegSchool() {
        return view('log-reg', [
            'schools' => School::all()
        ]);
    }
}
