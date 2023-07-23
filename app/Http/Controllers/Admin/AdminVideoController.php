<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class AdminVideoController extends Controller
{
    public function index()
    {
        $videos = Video::all();
        return view('admin.video_view', compact('videos'));
    }
    public function add()
    {
        return view('admin.video_add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'video_id' => 'required',
        ]);

            Video::create([
                'video_id' => $request->video_id,
                'caption' => $request->caption
            ]);
        return redirect()->back()->with('success', 'Video has been added successfully.');

    }
    public function edit($id)
    {
        $video_data = Video::findOrFail($id);
        return view('admin.video_edit', compact('video_data'));
    }

    public function update(Request $request, $id)
    {
        $video_data = Video::findOrFail($id);
             $video_data->video_id = $request->video_id;
             $video_data->caption = $request->caption;
             $video_data->update();

        return redirect()->back()->with('success', 'Video has been updated successfully.');


    }

    public function destroy($id)
    {
        $video_data = Video::findOrFail($id);
        $video_data->delete();
        return redirect()->back()->with('success', 'Video has been deleted successfully.');


    }
}