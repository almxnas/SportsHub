<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::all();
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'sport_type' => 'required',
            'location' => 'required',
            'price_per_hour' => 'required|numeric',
            'image' => 'nullable|url',
        ]);
        Facility::create($request->all());
        return redirect()->route('admin.facilities.index')->with('success', 'Facility added.');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $facility->update($request->all());
        return redirect()->route('admin.facilities.index')->with('success', 'Facility updated.');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();
        return back()->with('success', 'Facility deleted.');
    }
}