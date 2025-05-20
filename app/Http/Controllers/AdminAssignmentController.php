<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AdminAssignmentController extends Controller
{
    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);
        return view('admin.assignments.edit', compact('assignment'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $assignment = Assignment::findOrFail($id);
        $assignment->update($validated);

        return redirect()->route('workshop-detail', $assignment->workshop_id)
                         ->with('success', 'Assignment updated successfully.');
    }
}
