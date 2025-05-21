<?php

namespace App\Http\Controllers;

use App\Enums\ApprovalStatus;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showSubmissions() {}

    public function submitAssignment(Request $request, $id)
    {

        $assignment = Assignment::findOrFail($id);
        $teacher = auth('teacher')->user();

        $registration = Registration::where('teacher_id', $teacher->id)
            ->where('workshop_id', $assignment->workshop_id)
            ->first();

        if (!$registration) {
            return redirect()->back()->withErrors('No registration found for this workshop.');
        }

        //check if submission already exists
        $submission = Submission::where('assignment_id', $assignment->id)
            ->where('registration_id', $registration->id)
            ->first();

        $validated = $request->validate([
            'submissionLink' => 'required|url',
            'submissionNote'  => 'nullable|string',
            'submissionFile' => [
                $submission ? 'nullable' : 'required', //karena bisa null kl update ngga ganti file
                'file',
                'mimes:pdf',
                'max:1024'
            ],
        ]);

        if ($submission) {
            //update existing submission
            $submission->url = $validated['submissionLink'];
            $submission->note = $validated['submissionNote'];
            $submission->status = ApprovalStatus::Pending;

            if ($request->hasFile('submissionFile')) {
                //hapus dulu file lama
                if ($submission->path && Storage::disk('public')->exists(Str::after($submission->path, 'storage/'))) {
                    Storage::disk('public')->delete(Str::after($submission->path, 'storage/'));
                }

                $workshopName = Str::slug($assignment->workshop->title, '');
                $assignmentType = Str::slug($assignment->title, '');
                $path = "workshops/{$workshopName}/assignments/{$assignmentType}";
                $submissionFile = $request->file('submissionFile')->store($path, 'public');
                $submission->path = 'storage/' . $submissionFile;
            }

            $submission->save();
            $message = 'Submission updated!';
        } else {
            $workshop = $assignment->workshop;

            $workshopName = Str::slug($workshop->title, '');
            $assignmentType = Str::slug($assignment->title, '');

            $path = "workshops/{$workshopName}/assignments/{$assignmentType}";
            $submissionFile = $request->file('submissionFile')->store($path, 'public');
            $submissionFileUrl = 'storage/' . $submissionFile;

            // Create new
            Submission::create([
                'assignment_id' => $assignment->id,
                'title' => $assignment['workshop']['title'],
                'note' => $validated['submissionNote'],
                'url' => $validated['submissionLink'],
                'status' => ApprovalStatus::Pending,
                'path' => $submissionFileUrl,
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
