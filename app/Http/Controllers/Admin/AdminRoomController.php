<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomPhoto;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    public function index()
    {
        $rooms  = Room::all();
        return view('admin.room_view', compact('rooms'));
    }

    public function add()
    {
        $all_amenities = Amenity::all();
        return view('admin.room_add', compact('all_amenities'));
    }
    public function store(Request $request)
    {

        $amenities = '';
        $i = 0;
        if(isset($request->arr_amenities)){
            foreach($request->arr_amenities as $item){
                if($i == 0){
                    $amenities .= $item;
                } else {
                    $amenities .= ',' . $item;
                }
                $i++;
            }
        }




        $request->validate([
            'featured_photo' => 'required|image|mimes:jpg,jpeg,png,gif',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'total_rooms' => 'required',
        ]);

            $ext = $request->file('featured_photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('featured_photo')->move(public_path('uploads/'),$final_name);

            Room::create([
                'featured_photo' => $final_name,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'total_rooms' => $request->total_rooms,
                'amenities' => $amenities,
                'size' => $request->size,
                'total_beds' => $request->total_beds,
                'total_bathrooms' => $request->total_bathrooms,
                'total_balconies' => $request->total_balconies,
                'total_guests' => $request->total_guests,
                'video_id' => $request->video_id,
            ]);
        return redirect()->back()->with('success', 'Rooms has been added successfully.');

    }

    public function edit($id)
    {
        $all_amenities = Amenity::all();

        $room_data = Room::findOrFail($id);

        $existing_amenities = array();
        if($room_data->amenities != '') {
            $existing_amenities = explode(',', $room_data->amenities);
        }
        return view('admin.room_edit', compact('room_data', 'all_amenities', 'existing_amenities'));
    }

    public function update(Request $request, $id)
    {
        $room_data = Room::findOrFail($id);

        $amenities = '';
        $i = 0;
        if(isset($request->arr_amenities)){
            foreach($request->arr_amenities as $item){
                if($i == 0){
                    $amenities .= $item;
                } else {
                    $amenities .= ',' . $item;
                }
                $i++;
            }
        }

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'total_rooms' => 'required',
        ]);

        if($request->hasFile('featured_photo')){
            $request->validate([
                'photo' => 'mimes:jpg,jpeg,png,gif',
            ]);

            unlink(public_path('uploads/'.$room_data->featured_photo));
            $ext = $request->file('featured_photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('featured_photo')->move(public_path('uploads/'),$final_name);
            $room_data->featured_photo = $final_name;
        }



                $room_data->name = $request->name;
                $room_data->description = $request->description;
                $room_data->price = $request->price;
                $room_data->total_rooms = $request->total_rooms;
                $room_data->amenities = $amenities;
                $room_data->size= $request->size;
                $room_data->total_beds = $request->total_beds;
                $room_data->total_bathrooms = $request->total_bathrooms;
                $room_data->total_balconies = $request->total_balconies;
                $room_data->total_guests = $request->total_guests;
                $room_data->video_id = $request->video_id;
            $room_data->update();

        return redirect()->back()->with('success', 'Room has been updated successfully.');


    }

    public function destroy($id)
    {
        $room_data = Room::findOrFail($id);
        unlink(public_path('uploads/'.$room_data->featured_photo));

        $room_data->delete();
        $room_photo_data = RoomPhoto::where('room_id', $id)->get();
        foreach ($room_photo_data as $item){
            unlink(public_path('uploads/'.$item->photo));
            $item->delete();
        }
        return redirect()->back()->with('success', 'Room has been deleted successfully.');


    }

    public function gallery($id)
    {
        $room_data = Room::where('id',$id)->first();
        $room_photos = RoomPhoto::where('room_id',$id)->get();
        return view('admin.room_gallery', compact('room_data','room_photos'));
    }
    public function gallery_store(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,gif',
        ]);

        $ext = $request->file('photo')->extension();
            $final_name = time().'.'.$ext;
            $request->file('photo')->move(public_path('uploads/'),$final_name);

            RoomPhoto::create([
                'photo' => $final_name,
                'room_id' => $id,
            ]);
        return redirect()->back()->with('success', 'Room gallery has been added successfully.');
    }

    public function gallery_delete($id)
    {
        $single_data = RoomPhoto::where('id',$id)->first();
        unlink('uploads/'.$single_data->photo);
        $single_data->delete();

        return redirect()->back()->with('success', 'Photo is deleted successfully.');
    }
}
