<?php

namespace App\Http\Controllers;

use App\Models\Meet;
use App\Models\Presence;
use App\Models\Registration;
use App\Models\Teacher;
use App\Models\Workshop;
use Illuminate\Http\Request;

class AdminMeetController extends Controller
{

    public function show($id)
    {
        $meet = Meet::with('workshop')->findOrFail($id);

        // Get the related workshop for the meet
        $workshop = $meet->workshop;

        // Get all registrations for the workshop
        $registrations = Registration::where('workshop_id', $workshop->id)->where('isApproved', true)->get();

        // Get all teacher IDs from the registrations
        $teacherIds = $registrations->pluck('teacher_id')->toArray();

        // Get all teachers based on the teacher IDs
        $teachers = Teacher::whereIn('id', $teacherIds)->get();

        return view('admin-meets.show', [
            'teachers' => $teachers,
            'workshop' => $workshop,
            'registrations' => $registrations,
            'meet' => $meet
        ]);
    }

    public function create($workshopId)
    {
        $workshop = Workshop::findOrFail($workshopId);
        return view('admin-meets.edit', [
            'meet' => null,
            'workshop' => $workshop
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'workshop_id' => 'required|exists:workshops,id',
        ]);

        // Create the Meet
        $meet = Meet::create($validated);

        // Get all approved registrations for the workshop
        $approvedRegistrations = Registration::where('workshop_id', $validated['workshop_id'])
            ->where('isApproved', true) // assuming 'isApproved' is the approval flag
            ->get();

        // Create Presences for each registration
        foreach ($approvedRegistrations as $registration) {
            Presence::create([
                'meet_id' => $meet->id,
                'registration_id' => $registration->id,
                'isPresent' => false,
                'dateTime' => now(),
            ]);
        }

        return redirect()
            ->route('admin-meets.meets', $meet->workshop_id)
            ->with('success', 'New meet created and presences initialized.');
    }

    public function edit($id)
    {
        $meet = Meet::findOrFail($id);
        return view('admin-meets.edit', compact('meet'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $meet = Meet::findOrFail($id);
        $meet->update($validated);

        return redirect()->route('admin-meets.meets', $meet->workshop_id)
                         ->with('success', 'Meet updated successfully.');
    }
}
