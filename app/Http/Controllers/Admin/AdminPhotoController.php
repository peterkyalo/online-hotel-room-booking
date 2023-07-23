<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class AdminPhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::all();
        return view('admin.photo_view', compact('photos'));
    }
    public function add()
    {
        return view('admin.photo_add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif',
        ]);

            $ext = $request->file('photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('photo')->move(public_path('uploads/'),$final_name);

            Photo::create([
                'photo' => $final_name,
                'caption' => $request->caption
            ]);
        return redirect()->back()->with('success', 'Photo has been added successfully.');

    }
    public function edit($id)
    {
        $photo_data = Photo::findOrFail($id);
        return view('admin.photo_edit', compact('photo_data'));
    }

    public function update(Request $request, $id)
    {
        $photo_data = Photo::findOrFail($id);

        // dd($photo_data);

        if($request->hasFile('photo')){
            $request->validate([
                'photo' => 'mimes:jpg,jpeg,png,gif',
            ]);

            unlink(public_path('uploads/'.$photo_data->photo));
            $ext = $request->file('photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('photo')->move(public_path('uploads/'),$final_name);
            $photo_data->photo = $final_name;
        }


             $photo_data->caption = $request->caption;
            $photo_data->update();

        return redirect()->back()->with('success', 'Photo has been updated successfully.');


    }

    public function destroy($id)
    {
        $photo_data = Photo::findOrFail($id);
        unlink(public_path('uploads/'.$photo_data->photo));

        $photo_data->delete();
        return redirect()->back()->with('success', 'Photo has been deleted successfully.');


    }
}
