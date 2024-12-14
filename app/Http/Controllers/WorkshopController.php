<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    public function getAll () {
        return view('home', [
            'workshops' => Workshop::paginate(6)
        ]);
    }

    public function getById ($id) {

        $workshop = Workshop::getById($id);

        return view('workshop-detail', [
            'workshop' => $workshop
        ]);
    }
}
