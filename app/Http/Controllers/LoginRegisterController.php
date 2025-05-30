<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Mentor;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginRegisterController extends Controller
{
    public function logRegSchool() {
        // Check if the user is already authenticated
        if (Auth::check()) {
            // Redirect the user to the home route
            return redirect()->route('home');
        }
    
        // If not authenticated, return the view with the schools data
        return view('log-reg', [
            'schools' => School::all(),
            'mentors' => Mentor::all()
        ]);
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'school' => 'nullable|string|max:255',
            'newSchoolName' => 'required_without:school|nullable|string|max:255',
            'newSchoolAddress' => 'required_without:school|nullable|string|max:255',
            'newSchoolCity' => 'required_without:school|nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|max:255',
            'nuptk' => 'required|string|max:255',
            'community' => 'nullable|string|max:255',
            'mentor' => 'required|string|max:255',
        ]);

        if(isset ($validatedData['mentor'])) {
            $mentor = Mentor::where('name', $validatedData['mentor'])->first();
        }

        if (isset($validatedData['school'])) {
            $school = School::where('name', $validatedData['school'])->first();
        } else {
            $school = School::firstOrCreate(
                ['name' => $validatedData['newSchoolName']],
                [
                    'name' => $validatedData['newSchoolName'],
                    'address' => $validatedData['newSchoolAddress'],
                    'city' => $validatedData['newSchoolCity']
                ]
            );
        }

        $existingTeacher = Teacher::where('email', $validatedData['email'])->first();

        if ($existingTeacher) {
            return back()->withErrors(['email' => 'Email ini Sudah Terdaftar.'])->withInput();
        }

        $teacher = Teacher::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone'],
            'password' => bcrypt($validatedData['password']), // Hash the password before storing
            'nuptk' => $validatedData['nuptk'],
            'community' => $validatedData['community'],
            'school_id' => $school->id,
            'mentor_id' => $mentor->id
        ]);

        Auth::guard('teacher')->login($teacher);

        return redirect($request['pageBefore']);
    }       

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('teacher')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect($request['pageBefore']);
        }

        return back()->withErrors([
            'email' => 'Email / Password yang Anda Masukkan Salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        {
            Auth::guard('teacher')->logout();
    
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect()->route('home');
        }
    }
}
