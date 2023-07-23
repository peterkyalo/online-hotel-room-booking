<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('admin.testimonial_view', compact('testimonials'));
    }
    public function add()
    {
        return view('admin.testimonial_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif',
            'name' => 'required|min:3',
            'designation' => 'required|min:3',
            'comment' => 'required|min:5'
        ]);

            $ext = $request->file('photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('photo')->move(public_path('uploads/'),$final_name);

            Testimonial::create([
                'photo' => $final_name,
                'name' => $request->name,
                'designation' => $request->designation,
                'comment' => $request->comment,
            ]);
        return redirect()->back()->with('success', 'Testimonial has been added successfully.');

    }

    public function edit($id)
    {
        $testimonial_data = testimonial::findOrFail($id);
        return view('admin.testimonial_edit', compact('testimonial_data'));
    }

    public function update(Request $request, $id)
    {
        $testimonial_data = Testimonial::findOrFail($id);

        if($request->hasFile('photo')){
            $request->validate([
                'photo' => 'required|image|mimes:jpg,jpeg,png,gif',
            ]);

            unlink(public_path('uploads/'.$testimonial_data->photo));
            $ext = $request->file('photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('photo')->move(public_path('uploads/'),$final_name);
            $testimonial_data->photo = $final_name;
        }



             $testimonial_data->name = $request->name;
             $testimonial_data->designation = $request->designation;
             $testimonial_data->comment = $request->comment;
             $testimonial_data->update();

        return redirect()->back()->with('success', 'Testimonial has been updated successfully.');


    }
    public function destroy($id)
    {
        $single_data = Testimonial::findOrFail($id);
        unlink(public_path('uploads/'.$single_data->photo));

        $single_data->delete();
        return redirect()->back()->with('success', 'Testimonial has been deleted successfully.');


    }
}