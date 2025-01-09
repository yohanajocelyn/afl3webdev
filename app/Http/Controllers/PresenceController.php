<?php

namespace App\Http\Controllers;

use App\Models\Meet;
use App\Models\Presence;
use App\Models\Registration;
use App\Models\Teacher;
use App\Models\Workshop;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show()
    {
        $id = request()->query('meetId');

    // Find the Meet by ID
    $meet = Meet::find($id);

    if (!$meet) {
        return redirect()->route('workshops.index')->withErrors('Meet not found');
    }

    // Get the related workshop for the meet
    $workshop = $meet->workshop;

    // Get all registrations for the workshop
    $registrations = Registration::where('workshop_id', $workshop->id)->get();

    // Get all teacher IDs from the registrations
    $teacherIds = $registrations->pluck('teacher_id')->toArray();

    // Get all teachers based on the teacher IDs
    $teachers = Teacher::whereIn('id', $teacherIds)->get();

    return view('mark-presence', [
        'teachers' => $teachers,
        'workshop' => $workshop,
        'registrations' => $registrations,
        'meet' => $meet
    ]);
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
    public function update($presenceId)
    {
        $presence = Presence::find($presenceId);

        if (!$presence) {
            return response()->json(['success' => false, 'message' => 'Presence not found'], 404);
        }

        $presence->isPresent = !$presence->isPresent;
        $presence->save();

        return response()->json([
            'success' => true,
            'isPresent' => $presence->isPresent
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
