<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Post;
use App\Models\Room;
use App\Models\Slide;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slide_images  = Slide::all();
        $feature_all = Feature::all();
        $testimonial_all = Testimonial::all();
        $post_all = Post::orderBy('id', 'desc')->limit(3)->get();
        $room_all = Room::all();

        return view('front.home', compact('slide_images', 'feature_all', 'testimonial_all', 'post_all', 'room_all'));
    }
}