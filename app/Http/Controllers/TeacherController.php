<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use App\Models\Registration;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Enums\Role;
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

        // Get ongoing workshops the teacher has joined and are approved
        $joinedWorkshops = Registration::with('workshop')
            ->where('teacher_id', $id)
            ->where('isApproved', true)
            ->whereHas('workshop', function ($query) {
                $query->where('endDate', '>', now());
            })
            ->get();

        // Get pending workshops where teacher's registration is not approved yet
        $pendingWorkshops = Registration::with('workshop')
            ->where('teacher_id', $id)
            ->where('isApproved', false)
            ->get();

        // Get history workshops (teacher joined and finished)
        $historyWorkshops = Registration::with('workshop')
            ->where('teacher_id', $id)
            ->whereHas('workshop', function ($query) {
                $query->where('endDate', '<=', now());
            })
            ->get();

        // Get workshop IDs teacher is registered to (approved only)
        $workshopIds = Registration::where('teacher_id', $id)
            ->where('isApproved', true)
            ->pluck('workshop_id');

        // Fetch assignments from those workshops, with submissions from this teacher
        $assignments = Assignment::with(['workshop', 'submissions' => function ($query) use ($id) {
            $query->whereHas('registration', function ($q) use ($id) {
                $q->where('teacher_id', $id);
            });
        }])
            ->whereIn('workshop_id', $workshopIds)
            ->orderByDesc('created_at')
            ->get();


        // Filter assignments without any submission from this teacher
        $noSubmission = $assignments->filter(fn($assignment) => $assignment->submissions->isEmpty());

        // Assignments with submissions but not approved yet
        $submittedNotApproved = $assignments->filter(function ($assignment) {
            $submission = $assignment->submissions->first();
            return $submission && $submission->url && !$submission->isApproved;
        });

        // Assignments with approved submissions
        $approved = $assignments->filter(function ($assignment) {
            $submission = $assignment->submissions->first();
            return $submission && $submission->url && $submission->isApproved;
        });

        return view('teachersprofile', [
            "teacher" => $teacher,
            "joinedWorkshops" => $joinedWorkshops,
            "pendingWorkshops" => $pendingWorkshops,
            "historyWorkshops" => $historyWorkshops,
            "ongoingAssignments" => $noSubmission,
            "doneAssignments" => $submittedNotApproved,
            "approvedAssignments" => $approved
        ]);
    }


    public function teachersListView()
    {
        $id = request()->query('schoolId');
        if ($id == null) {
            return view('teachers', [
                "state" => "teachers list",
                "teachers" => Teacher::all()
            ]);
        } else {
            return view('teachers', [
                "state" => "teachers list with school",
                "teachers" => Teacher::dataWithSchoolId($id),
                "school" => School::dataWithId($id)
            ]);
        }
    }
}
