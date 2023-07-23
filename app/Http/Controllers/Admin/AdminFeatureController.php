<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class AdminFeatureController extends Controller
{
    public function index()
    {
        $features  = Feature::all();
        return view('admin.feature_view', compact('features'));
    }

    public function add()
    {
        return view('admin.feature_add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required',
            'heading' => 'required',
        ]);

            Feature::create([
                'icon' => $request->icon,
                'heading' => $request->heading,
                'text' => $request->text,
            ]);
        return redirect()->back()->with('success', 'Feature has been added successfully.');

    }
    public function edit($id)
    {
        $feature_data = Feature::findOrFail($id);
        return view('admin.feature_edit', compact('feature_data'));
    }

    public function update(Request $request, $id)
    {
        $feature_data = Feature::findOrFail($id);


             $feature_data->icon = $request->icon;
             $feature_data->heading = $request->heading;
             $feature_data->text = $request->text;
            $feature_data->update();

        return redirect()->back()->with('success', 'Feature has been updated successfully.');


    }

    public function destroy($id)
    {
        $feature_data = Feature::findOrFail($id);

        $feature_data->delete();
        return redirect()->back()->with('success', 'Feature has been deleted successfully.');


    }
}
