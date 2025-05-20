<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class AdminSchoolController extends Controller
{
    public function index()
    {
        $schools = School::paginate(10);

        return view('admin-schools.schools', compact('schools'));
    }

    public function create()
    {
        return view('admin-schools.create', [
            'school' => null
        ]);
    }

    public function edit($id)
    {
        $schools = School::findOrFail($id);

        return view('admin-schools.create', compact('schools'));
    }
}
