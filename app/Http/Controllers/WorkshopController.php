<?php

namespace App\Http\Controllers;

use App\Enums\ApprovalStatus;
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
use Illuminate\Support\Facades\Log;

class WorkshopController extends Controller
{

    public function show($id)
    {
        $workshop = Workshop::with(['meets', 'assignments'])->findOrFail($id);
        return view('filament.pages.workshop-detail', compact('workshop'));
    }

    public function getAll() {
        $workshops = Workshop::paginate(6);
    
        $workshops->getCollection()->transform(function ($workshop) {
            $startDate = Carbon::parse($workshop->startDate);
            $endDate = Carbon::parse($workshop->endDate);
            // $startDate = $workshop->startDate->format('Y-m-d H:i');
            // $endDate = $workshop->endDate->format('Y-m-d H:i');
    
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
            'paymentProof' => $paymentProof, 
            'isApproved' => $isApproved,
            'courseStatus' => CourseStatus::Assigned,
            'teacher_id' => $teacherId,
            'workshop_id' => $workshopId,
        ]);

        $meets = Meet::where('workshop_id', $workshopId)->get();
        if($meets->count() > 0){
            foreach($meets as $meet){
                Presence::create([
                    'meet_id' => $meet['id'],
                    'registration_id' => $registration['id'],
                    'status' => ApprovalStatus::Pending,
                    'dateTime' => now()
                ]);
            }
        }

        return redirect(url()->previous());

    }


}
