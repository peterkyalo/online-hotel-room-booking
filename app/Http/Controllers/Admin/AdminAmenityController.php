<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AdminAmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::all();
        return view('admin.amenity_view', compact('amenities'));
    }

    public function add()
    {
        return view('admin.amenity_add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
        ]);

        Amenity::create([
                'name' => $request->name
            ]);
        return redirect()->back()->with('success', 'Amenity has been added successfully.');

    }

    public function edit($id)
    {
        $amenity_data = Amenity::findOrFail($id);
        return view('admin.amenity_edit', compact('amenity_data'));
    }

    public function update(Request $request, $id)
    {
        $amenity_data = Amenity::findOrFail($id);
             $amenity_data->name = $request->name;
             $amenity_data->update();

        return redirect()->back()->with('success', 'Amenity has been updated successfully.');


    }

    public function destroy($id)
    {
        $amenity_data = Amenity::findOrFail($id);
        $amenity_data->delete();
        return redirect()->back()->with('success', 'Amenity has been deleted successfully.');


    }
}