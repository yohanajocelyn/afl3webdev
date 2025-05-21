<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Registration;
use Illuminate\Http\Request;


class AssignmentController extends Controller
{
    public function assignmentDetail(Request $request)
    {
        $assignmentId = $request->query('assignmentId');
        $assignment = Assignment::findOrFail($assignmentId);

        $teacherId = auth('teacher')->id();

        //check ada regis or no from the teacher
        $registration = Registration::where('teacher_id', $teacherId)
            ->where('workshop_id', $assignment->workshop_id)
            ->first();

        $userSubmission = null;

        if ($registration) {
            $userSubmission = Submission::where('assignment_id', $assignmentId)
                ->where('registration_id', $registration->id)
                ->first();
        }

        return view('assignment-details', [
            'assignment' => $assignment,
            'userSubmission' => $userSubmission,
        ]);
    }

    public function editAssignment(Request $request)
    {
        // Validate the request data (optional but recommended)
        $validatedData = $request->validate([
            'assignmentId' => 'required|integer',
            'title' => 'required|string',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);

        $id = $request->assignmentId;

        $assignment = Assignment::find($id);

        if (!$assignment) {
            return;
        }

        $assignment->update([
            'title' => $validatedData['title'],
            'due_dateTime' => $validatedData['date'],
            'description' => $validatedData['description']
        ]);

        return redirect(url()->previous());
    }
}
