<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;


class SubmissionController extends Controller
{
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
}
