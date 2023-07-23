<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;

class AdminSlideController extends Controller
{
    public function index()
    {
        $slides  = Slide::all();
        return view('admin.slide_view', compact('slides'));
    }
    public function add()
    {
        return view('admin.slide_add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif',
        ]);

            $ext = $request->file('photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('photo')->move(public_path('uploads/'),$final_name);

            Slide::create([
                'photo' => $final_name,
                'heading' => $request->heading,
                'text' => $request->text,
                'button_text' => $request->button_text,
                'button_url' => $request->button_url,
            ]);
        return redirect()->back()->with('success', 'Slide has been added successfully.');

    }

    public function edit($id)
    {
        $slide_data = Slide::findOrFail($id);
        return view('admin.slide_edit', compact('slide_data'));
    }

    public function update(Request $request, $id)
    {
        $slide_data = Slide::findOrFail($id);

        // dd($slide_data);

        if($request->hasFile('photo')){
            $request->validate([
                'photo' => 'mimes:jpg,jpeg,png,gif',
            ]);

            unlink(public_path('uploads/'.$slide_data->photo));
            $ext = $request->file('photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('photo')->move(public_path('uploads/'),$final_name);
            $slide_data->photo = $final_name;
        }


             $slide_data->heading = $request->heading;
             $slide_data->text = $request->text;
             $slide_data->button_text = $request->button_text;
             $slide_data->button_url = $request->button_url;
            $slide_data->update();

        return redirect()->back()->with('success', 'Slide has been updated successfully.');


    }

    public function destroy($id)
    {
        $slide_data = Slide::findOrFail($id);
        unlink(public_path('uploads/'.$slide_data->photo));

        $slide_data->delete();
        return redirect()->back()->with('success', 'Slide has been deleted successfully.');


    }
}
