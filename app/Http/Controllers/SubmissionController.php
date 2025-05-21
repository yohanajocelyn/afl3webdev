<?php

namespace App\Http\Controllers;

use App\Enums\ApprovalStatus;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use App\Models\Registration;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showSubmissions()
    {

    }

    public function submitAssignment(Request $request, $id)
    {
        $validated = $request->validate([
            'submissionLink' => 'required|url',
        ]);

        $assignment = Assignment::findOrFail($id);
        $teacher = auth('teacher')->user();

        $registration = Registration::where('teacher_id', $teacher->id)
            ->where('workshop_id', $assignment->workshop_id)
            ->first();

        if (!$registration) {
            return redirect()->back()->withErrors('No registration found for this workshop.');
        }

        // Check if submission already exists
        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('registration_id', $registration->id)
            ->first();

        if ($submission) {
            // Update existing submission
            $submission->url = $validated['submissionLink'];
            $submission->note = $request['submissionNoteEdit'];
            $submission->save();
            $message = 'Submission updated!';
        } else {
            // Create new
            Submission::create([
                'assignment_id' => $assignment->id,
                'title' => $assignment['workshop']['title'],
                'note' => $request['submissionNote'],
                'url' => $validated['submissionLink'],
                'status' => ApprovalStatus::Pending,

                'registration_id' => $registration->id,
            ]);
            $message = 'Submission successful!';
        }

        return redirect()->route('assignment-detail', ['assignmentId' => $assignment->id])
            ->with('success', $message);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function createSubmission() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Submission $submission): RedirectResponse
    {
        $submission->update(['isApproved' => true]);

        return redirect()
            ->route('filament.admin.pages.submission-detail', ['record' => $submission->id])
            ->with('success', 'Submission approved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $submission = Submission::findOrFail($id);

        if ($submission->isApproved) {
            return redirect()->back()->withErrors('Approved submissions cannot be deleted.');
        }

        $submission->delete();

        return redirect()->route('assignment-detail', ['assignmentId' => $submission->assignment_id])
            ->with('success', 'Submission deleted successfully.');
    }
}
