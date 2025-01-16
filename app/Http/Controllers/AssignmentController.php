<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;


class AssignmentController extends Controller
{
    public function assignmentDetail(Request $request){
        $id = $request->query('assignmentId');

        $assignment = Assignment::findOrFail($id);

        return view('assignment-details', [
            'assignment' => $assignment
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
            return ;
        }

        $assignment->update([
            'title' => $validatedData['title'],
            'date' => $validatedData['date'],
            'description' => $validatedData['description']
        ]);

        return redirect(url()->previous());
    }
}
