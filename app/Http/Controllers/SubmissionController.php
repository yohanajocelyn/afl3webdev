<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubmissionController extends Controller
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
        //
    }
}
