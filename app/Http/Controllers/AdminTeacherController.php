<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;

class AdminTeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with('school');

        if ($request->has('school_id') && $request->school_id !== null) {
            $query->where('school_id', $request->school_id);
        }

        $teachers = $query->orderBy('name')->paginate(10);
        $schools = School::orderBy('name')->get();

        return view('admin-teachers.teachers', compact('teachers', 'schools'));
    }

    public function create()
    {
        $schools = School::all();
        return view('admin-teachers.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|string|min:6',
            'school_id' => 'nullable|exists:schools,id',
            'role' => 'required|in:user,admin,superadmin',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        Teacher::create($validated);

        return redirect()->route('admin-teachers.teachers')->with('success', 'Teacher created.');
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        $schools = School::all();

        return view('admin-teachers.create', compact('teacher', 'schools'));
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:teachers,email,$id",
            'password' => 'nullable|string|min:6',
            'school_id' => 'nullable|exists:schools,id',
            'role' => 'required|in:user,admin,superadmin',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $teacher->update($validated);

        return redirect()->route('admin-teachers.teachers')->with('success', 'Teacher updated.');
    }
}
