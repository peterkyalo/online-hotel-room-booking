<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile');
    }

    public function profile_submit(Request $request)
    {
        $admin_data = Admin::where('email', Auth::guard('admin')->user()->email)->first();

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
        ]);

        if($request->password != ""){
            $request->validate([
                'password' => 'required|min:8',
                'retype_password' => 'required|same:password',
            ]);
            $admin_data->password = Hash::make($request->password);
        }

        //image upload
        if($request->hasFile('photo')){
            $request->validate([
                'photo' => 'image|mimes:jpg,jpeg,png,gif',
            ]);

            unlink(public_path('uploads/'.$admin_data->photo));
            $ext = $request->file('photo')->extension();

            $final_name = 'admin'.'.'.$ext;
            $request->file('photo')->move(public_path('uploads/'),$final_name);
            //save image into database
            $admin_data->photo = $final_name;
        }

        $admin_data->name = $request->name;
        $admin_data->email = $request->email;

        $admin_data->update();

        return redirect()->back()->with('success', 'Your profile information has been updated successfully.');

    }
}