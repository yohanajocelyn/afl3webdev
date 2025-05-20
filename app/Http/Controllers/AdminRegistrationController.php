<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Workshop;
use Illuminate\Http\Request;

class AdminRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['teacher.school', 'workshop']);

        if ($request->has('workshop_id') && $request->workshop_id !== null) {
            $query->where('workshop_id', $request->workshop_id);
        }

        $registrations = $query->orderBy('regDate', 'desc')->paginate(10);

        $workshops = Workshop::all();

        return view('admin-registrations.registrations', [
            'registrations' => $registrations,
            'workshops' => $workshops
        ]);
    }
}
