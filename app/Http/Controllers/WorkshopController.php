<?php

namespace App\Http\Controllers;

use App\Enums\CourseStatus;
use App\Models\Assignment;
use App\Models\Meet;
use App\Models\Presence;
use App\Models\Registration;
use App\Models\Teacher;
use App\Models\Workshop;
use DateTime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorkshopController extends Controller
{
    public function getAll() {
        $workshops = Workshop::paginate(6);
    
        $workshops->getCollection()->transform(function ($workshop) {
            $startDate = Carbon::parse($workshop->startDate);
            $endDate = Carbon::parse($workshop->endDate);
    
            $workshop->duration = $startDate->diffInDays($endDate) + 1; 
    
            return $workshop;
        });
    
        return view('home', [
            'workshops' => $workshops
        ]);
    }

    public function getById ($id) {

        $workshop = Workshop::getById($id);
        $registrations = Registration::with(['teacher', 'workshop'])
        ->where('workshop_id', $id)
        ->get();
        
        return view('workshop-detail', [
            'workshop' => $workshop,
            'registrations' => $registrations
        ]);
    }

    public function createWorkshop(Request $request){
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

        $workshopImage = $request->file('workshop_image')->store('workshop_banners', 'public');
        $workshopImage = 'storage/' . $workshopImage;

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

            Assignment::create([
                'workshop_id' => $workshop->id,
                'title' => $title,
                'date' => $validatedData['assignment_due_date'],
                'description' => ""
            ]);
        }

        return redirect()->route('workshop-detail', ['id' => $workshop->id])
        ->with('success', 'Workshop and its assignments created successfully');
    }

    public function registerWorkshop(Request $request){

        $workshopId = $request->workshopId;
        $workshop = Workshop::findOrFail($workshopId);
        if($workshop['price'] == 0){
            $paymentProof = 'null';
            $isApproved = 1;
        }else{
            $paymentProof = $request->file('registrationProof')->store('registration_proofs', 'public');
            $paymentProof = 'storage/' . $paymentProof;
            $isApproved = 0;
        }

        if (!auth('teacher')->check()) {
            abort(403, 'You must be logged in to register.');
        }

        $teacherId = auth('teacher')->user()->id;

        $registration = Registration::create([
            'regDate' => now(),
            'paymentProof' => $paymentProof, 
            'isApproved' => $isApproved,
            'courseStatus' => CourseStatus::Assigned,
            'teacher_id' => $teacherId,
            'workshop_id' => $workshopId,
        ]);

        $meets = Meet::where('workshop_id', $workshopId)->get();
        foreach($meets as $meet){
            Presence::create([
                'meet_id' => $meet['id'],
                'registration_id' => $registration['id'],
                'isPresent' => false,
                'dateTime' => now() 
            ]);
        }

        return redirect(url()->previous());

    }

    public function showRegistration(){
        $id = request()->query('workshopId');
        if($id){
            $registrations = Registration::with(['teacher', 'workshop'])
            ->where('workshop_id', $id)
            ->get();
        }else{
            $registrations = Registration::with(['teacher', 'workshop'])->get();
        }

        $workshop = Workshop::where('id', $id)->first();

        return view('registrations', [
            "registrations" => $registrations,
            'workshop' => $workshop
        ]);
    }

    public function teacherRegistered(){
        $teachers = Registration::with(['teacher', 'workshop'])->get();
    }

    public function createMeet(Request $request) {
        $workshopId = $request->input('workshopId');
    
        $validatedData = $request->validate([
            'title' => 'required|string',
            'date' => 'required|date',
            'description' => 'required|string'
        ]);
    
        $existingMeet = Meet::where([
            'workshop_id' => $workshopId,
            'title' => $validatedData['title'],
            'date' => $validatedData['date']
        ])->first();
    
        if ($existingMeet) {
            return back()->withErrors(['title' => 'This Meet already exists for the selected date'])->withInput();
        }
    
            $meet = Meet::create([
                'title' => $validatedData['title'],
                'date' => $validatedData['date'],
                'description' => $validatedData['description'],
                'workshop_id' => $workshopId
            ]);
    
            $registeredUsers = Registration::where('workshop_id', $workshopId)->get();
    
            if ($registeredUsers->isNotEmpty()) {
                foreach ($registeredUsers as $registered) {
                    Presence::create([
                        'meet_id' => $meet->id,
                        'registration_id' => $registered->id,
                        'isPresent' => false,
                        'dateTime' => now()
                    ]);
                }
            }
    
            return redirect(url()->previous())->with('success', 'Meet created successfully!');
    }
    
    public function showProgress(Request $request){
        $id = $request->query('workshopId');

        $workshop = Workshop::with([
            'registrations.teacher',
            'registrations.submissions',
            'assignments'
        ])->findOrFail($id);
    
        return view('workshop-progress', compact('workshop'));
    }

    public function openWorkshop(Request $request)
    {
        $workshopId = $request->workshopId;
        $workshop = Workshop::findOrFail($workshopId);

        $workshop->update([
            'isOpen' => !$workshop->isOpen,
        ]);

        return redirect()->back();
    }
}
