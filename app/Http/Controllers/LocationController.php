<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocationCheck;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locationCheck = LocationCheck::first();

        return view('admin.location.index', compact('locationCheck'));
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
        // check the current status of location_check in the database, if it's changed then store it
        $locationCheck = LocationCheck::first();

        // convert the value to boolean
        $result = $request->toggleLocationCheck == '1' ? true : false;

        // check if it's null then create new one
        if ($locationCheck == null) {
            LocationCheck::create([
                'is_active' => 0,
            ]);
        }

        if ($locationCheck->is_active != $result) {
            $locationCheck->update([
                'is_active' => $result,
            ]);
        }

        // Redirect back to the form with a success message
        return redirect('admin/location')->with('success', 'Location check has been updated.');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
