<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminWorkshopController extends Controller
{
    public function index()
    {
        $workshops = Workshop::withCount(['meets', 'assignments'])->get(); // eager-load counts
        return view('admin-workshop.workshops', compact('workshops'));
    }

    public function show($id)
    {
        $workshop = Workshop::with(['meets', 'assignments'])->findOrFail($id);
        return view('admin-workshop.workshops-detail', compact('workshop'));
    }

    public function create()
    {
        return view('admin-workshop.workshops-create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|integer',
            'assignment_count' => 'required|integer|min:1',
            'assignment_due_date' => 'required|date|after_or_equal:end_date',
            'workshop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $workshopImage = 'default.jpg';
        if($request->hasFile('workshop_image')){
            $workshopImage = $request->file('workshop_image')->store('workshop_banners', 'public');
            $workshopImage = 'storage/' . $workshopImage;
        }

        $existingWorkshop = Workshop::where('title', $validatedData['title'])
        ->where('startDate', $validatedData['start_date'])
        ->where('endDate', $validatedData['end_date'])
        ->first();

        if ($existingWorkshop) {
            return back()->withErrors(['title' => 'This workshop with the same title and date already exists.'])->withInput();
        }

        //create
        $workshop = Workshop::create([
            'title' => $validatedData['title'],
            'startDate' => $validatedData['start_date'],
            'endDate' => $validatedData['end_date'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'imageURL'=> $workshopImage,
            'isOpen' => false
        ]);

        //assignment from workshop creation
        for ($i = 1; $i <= $validatedData['assignment_count']+2; $i++) {
            $title = '';
            if($i === 1){
                $title = 'pre-test';
            }else if($i === 2){
                $title = 'post-test';
            }else{
                $title = 'Assignment '. ($i - 2);
            }

            Log::info('Creating Assignment:', ['title' => $title, 'workshop_id' => $workshop->id]);

            Assignment::create([
                'workshop_id' => $workshop->id,
                'title' => $title,
                'date' => $validatedData['assignment_due_date'],
                'description' => ""
            ]);
        }

        return redirect()->route('admin-workshop.admin-workshops')->with('success', 'Workshop added successfully.');
    }

    public function edit($id)
    {
        $workshop = Workshop::findOrFail($id);
        return view('admin-workshop.workshop-edit', compact('workshop'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|integer',
            'assignment_count' => 'required|integer|min:1',
            'assignment_due_date' => 'required|date|after_or_equal:end_date',
            'workshop_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $workshop = Workshop::findOrFail($id);

        // Check for duplicate workshop title/dates (excluding self)
        $existingWorkshop = Workshop::where('title', $validatedData['title'])
            ->where('startDate', $validatedData['start_date'])
            ->where('endDate', $validatedData['end_date'])
            ->where('id', '!=', $workshop->id)
            ->first();

        if ($existingWorkshop) {
            return back()->withErrors(['title' => 'This workshop with the same title and date already exists.'])->withInput();
        }

        // Handle image update
        if ($request->hasFile('workshop_image')) {
            $workshopImagePath = $request->file('workshop_image')->store('workshop_banners', 'public');
            $workshop->imageURL = 'storage/' . $workshopImagePath;
        }

        // Update workshop fields
        $workshop->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'startDate' => $validatedData['start_date'],
            'endDate' => $validatedData['end_date'],
            'price' => $validatedData['price'],
        ]);

        // Delete existing assignments and recreate
        Assignment::where('workshop_id', $workshop->id)->delete();

        for ($i = 1; $i <= $validatedData['assignment_count'] + 2; $i++) {
            $title = match($i) {
                1 => 'pre-test',
                2 => 'post-test',
                default => 'Assignment ' . ($i - 2),
            };

            Log::info('Updating Assignment:', ['title' => $title, 'workshop_id' => $workshop->id]);

            Assignment::create([
                'workshop_id' => $workshop->id,
                'title' => $title,
                'date' => $validatedData['assignment_due_date'],
                'description' => '',
            ]);
        }

        return redirect()->route('admin-workshop.workshops')->with('success', 'Workshop added successfully.');
    }

    public function toggleStatus($id)
    {
        $workshop = Workshop::findOrFail($id);
        $workshop->isOpen = !$workshop->isOpen;
        $workshop->save();

        return response()->json([
            'success' => true,
            'isOpen' => $workshop->isOpen,
        ]);
    }

}

