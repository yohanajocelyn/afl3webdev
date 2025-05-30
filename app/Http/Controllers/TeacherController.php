<?php

namespace App\Http\Controllers;

use App\Enums\ApprovalStatus;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Registration;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class TeacherController extends Controller
{
    public function getProfile()
    {
        $id = request()->query('teacherId');
        $teacher = Teacher::dataWithId($id);

        if (!$id || !$teacher) {
            abort(404, "Teacher not found.");
        }

        return view('teachersprofile', [
            "teacher" => $teacher
        ]);
    }

    public function editProfile(Request $request)
    {
        $teacher = Auth::guard('teacher')->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:teachers,email,' . $teacher->id,
            'phone_number' => 'required|string|max:20',
            'nuptk' => 'required|string|max:255',
            'community' => 'nullable|string|max:255',
        ]);

        // Handle school data
        // if (isset($validatedData['school'])) {
        //     $school = School::where('name', $validatedData['school'])->first();
        // } else {
        //     $school = School::firstOrCreate(
        //         ['name' => $validatedData['newSchoolName']],
        //         [
        //             'name' => $validatedData['newSchoolName'],
        //             'address' => $validatedData['newSchoolAddress'],
        //             'city' => $validatedData['newSchoolCity']
        //         ]
        //     );
        // }

        // Handle profile picture upload
        // if ($request->hasFile('profile_picture')) {
        //     $path = $request->file('profile_picture')->store('profile_pictures', 'public');
        //     $teacher->pfpURL = 'storage/' . $path;
        // }

        // Update teacher details
        $teacher->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'nuptk' => $validatedData['nuptk'],
            'community' => $validatedData['community'],
            // 'school_id' => $school->id
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }


    public function getCourses()
    {
        $teacher = Auth::guard('teacher')->user();
        $teacher_id = $teacher['id'];

        if (!$teacher) {
            abort(404, "Teacher not found.");
        }

        // Get ongoing workshops the teacher has joined and are approved
        $joinedWorkshops = Registration::with('workshop')
            ->where('teacher_id', $teacher_id)
            ->where('isApproved', true)
            ->whereHas('workshop', function ($query) {
                $query->where('endDate', '>', now());
            })
            ->get();

        // Get pending workshops where teacher's registration is not approved yet
        $pendingWorkshops = Registration::with('workshop')
            ->where('teacher_id', $teacher_id)
            ->where('isApproved', false)
            ->get();

        // Get history workshops (teacher joined and finished)
        $historyWorkshops = Registration::with('workshop')
            ->where('teacher_id', $teacher_id)
            ->whereHas('workshop', function ($query) {
                $query->where('endDate', '<=', now());
            })
            ->get();

        // Get workshop IDs teacher is registered to (approved only)
        $workshopIds = Registration::where('teacher_id', $teacher_id)
            ->where('isApproved', true)
            ->pluck('workshop_id');

        // Fetch assignments from those workshops, with submissions from this teacher
        $assignments = Assignment::with(['workshop', 'submissions' => function ($query) use ($teacher_id) {
            $query->whereHas('registration', function ($q) use ($teacher_id) {
                $q->where('teacher_id', $teacher_id);
            });
        }])
            ->whereIn('workshop_id', $workshopIds)
            ->orderByDesc('created_at')
            ->get();


        //belum dikerjakan = no submission
        $noSubmission = $assignments->filter(fn($assignment) => $assignment->submissions->isEmpty());

        //menunggu Persetujuan = status pending
        $pending = $assignments->filter(function ($assignment) {
            $submission = $assignment->submissions->first();
            return $submission && $submission->status === ApprovalStatus::Pending;
        });

        //approved
        $approved = $assignments->filter(function ($assignment) {
            $submission = $assignment->submissions->first();
            return $submission && $submission->status === ApprovalStatus::Approved;
        });

        //need revision
        $needRevision = $assignments->filter(function ($assignment) {
            $submission = $assignment->submissions->first();
            return $submission && $submission->status === ApprovalStatus::Rejected;
        });

        return view('my-courses', [
            "teacher" => $teacher,
            "joinedWorkshops" => $joinedWorkshops,
            "pendingWorkshops" => $pendingWorkshops,
            "historyWorkshops" => $historyWorkshops,
            "noSubmission" => $noSubmission,
            "pendingAssignments" => $pending,
            "approvedAssignments" => $approved,
            "needRevisionAssignments" => $needRevision,
            "ApprovalStatus" => ApprovalStatus::class, 
        ]);
    }
}
