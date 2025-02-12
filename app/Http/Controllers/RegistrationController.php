<?php

namespace App\Http\Controllers;

use App\Models\Meet;
use App\Models\Presence;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
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
    public function update($registrationId)
    {
        $registration = Registration::find($registrationId);

        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'Registration not found'], 404);
        }

        $registration->isApproved = !$registration->isApproved;
        $registration->save();

        $meets = Meet::where('workshop_id', $registration->workshop_id)->get();
        foreach($meets as $meet){
            Presence::firstOrCreate([
                'meet_id' => $meet->id,
                'registration_id' => $registration->id,
                'isPresent' => false,
                'dateTime' => now() 
            ]);
        }

        return response()->json([
            'success' => true,
            'isApproved' => $registration->isApproved
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
