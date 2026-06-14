<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Facility::query();

        if ($request->filled('sport_type')) {
            $query->where('sport_type', $request->sport_type);
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $facilities = $query->get();
        return view('facilities.index', compact('facilities'));
    }

    public function show(Facility $facility)
    {
        $facility->load('reviews.user');
        return view('facilities.show', compact('facility'));
    }
}