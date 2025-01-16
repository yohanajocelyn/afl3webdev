<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showSubmissions(){
        $id = request()->query('assignmentId');
        if ($id) {
            $submissions = Submission::with(['registration.teacher', 'assignment'])
                ->where('assignment_id', $id)
                ->get();
        } else {
            $submissions = Submission::with(['registration.teacher', 'assignment'])->get();
        }

        $assignment = Assignment::where('id', $id)->first();

        return view('submissions', [
            "submissions" => $submissions,
            'assignment' => $assignment
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
    public function update($submmissionId)
    {
        $submission = Submission::find($submmissionId);

        if (!$submission) {
            return response()->json(['success' => false, 'message' => 'Submission not found'], 404);
        }

        $submission->isApproved = !$submission->isApproved;
        $submission->save();

        return response()->json([
            'success' => true,
            'isApproved' => $submission->isApproved
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
