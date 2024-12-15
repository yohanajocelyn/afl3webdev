<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\School;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginRegisterController extends Controller
{
    public function logRegSchool() {
        return view('log-reg', [
            'schools' => School::all()
        ]);
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'profile_picture' => 'nullable|string',
            'name' => 'required|string|max:255', // Required, must be a string with max length of 255
            'school' => 'nullable|string|max:255', // Optional, max length of 255
            'newSchoolName' => 'required_without:school|nullable|string|max:255',
            'newSchoolAddress' => 'required_without:school|nullable|string|max:255',
            'newSchoolCity' => 'required_without:school|nullable|string|max:255',
            'gender' => 'required|in:male,female', // Required, must be "male" or "female"
            'email' => 'required|email|max:255', // Required, must be a valid email
            'phone' => 'required|string|max:20', // Optional, max length of 20
            'password' => 'required|string|min:8|max:255', // Required, must be at least 8 characters
            'nuptk' => 'required|string|max:255', // Optional, max length of 255
            'community' => 'required|string|max:255', // Optional, max length of 255
            'subject' => 'required|string|max:255', // Optional, max length of 255
        ]);

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

        $profilePicture = $validatedData['profile_picture'] ?? 'default-profile-picture-url.jpg';

        $existingTeacher = Teacher::where('email', $validatedData['email'])->first();

        if ($existingTeacher) {
            return back()->withErrors(['email' => 'The email is already taken.'])->withInput();
        }

        $teacher = Teacher::create([
            'pfpUrl' => $profilePicture,
            'name' => $validatedData['name'],
            'gender' => $validatedData['gender'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone'],
            'password' => bcrypt($validatedData['password']), // Hash the password before storing
            'nuptk' => $validatedData['nuptk'],
            'community' => $validatedData['community'],
            'subjectTaught' => $validatedData['subject'],
            'role' => Role::User,
            'school_id' => $school->id
        ]);

        Auth::guard('teacher')->login($teacher);

        return redirect()->route('home');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('teacher')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
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
