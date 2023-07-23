<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('admin.post_view', compact('posts'));
    }
    public function add()
    {
        return view('admin.post_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif',
            'heading' => 'required|min:3',
            'short_content' => 'required|min:3',
            'content' => 'required|min:5'
        ]);

            $ext = $request->file('photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('photo')->move(public_path('uploads/'),$final_name);

            Post::create([
                'photo' => $final_name,
                'heading' => $request->heading,
                'short_content' => $request->short_content,
                'content' => $request->content,
                'total_view' => 1,
            ]);
        return redirect()->back()->with('success', 'Post has been added successfully.');

    }

    public function edit($id)
    {
        $post_data = Post::findOrFail($id);
        return view('admin.post_edit', compact('post_data'));
    }

    public function update(Request $request, $id)
    {
        $post_data = Post::findOrFail($id);

        if($request->hasFile('photo')){
            $request->validate([
                'photo' => 'required|image|mimes:jpg,jpeg,png,gif',
            ]);

            unlink(public_path('uploads/'.$post_data->photo));
            $ext = $request->file('photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('photo')->move(public_path('uploads/'),$final_name);
            $post_data->photo = $final_name;
        }



             $post_data->heading = $request->heading;
             $post_data->short_content = $request->short_content;
             $post_data->content = $request->content;
             $post_data->update();

        return redirect()->back()->with('success', 'Post has been updated successfully.');


    }
    public function destroy($id)
    {
        $single_data = Post::findOrFail($id);
        unlink(public_path('uploads/'.$single_data->photo));

        $single_data->delete();
        return redirect()->back()->with('success', 'Post has been deleted successfully.');


    }
}