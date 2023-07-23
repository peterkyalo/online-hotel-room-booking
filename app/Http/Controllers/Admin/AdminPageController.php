<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function about()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_about', compact('page_data'));
    }
    public function about_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->about_heading = $request->about_heading;
            $page_data->about_content = $request->about_content;
            $page_data->about_status = $request->about_status;
            $page_data->update();

        return redirect()->back()->with('success', 'About page has been updated successfully.');
    }
    public function terms()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_terms', compact('page_data'));
    }
    public function terms_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->terms_heading = $request->terms_heading;
            $page_data->terms_content = $request->terms_content;
            $page_data->terms_status = $request->terms_status;
            $page_data->update();

        return redirect()->back()->with('success', 'Terms page has been updated successfully.');
    }
    public function privacy()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_privacy', compact('page_data'));
    }
    public function privacy_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->privacy_heading = $request->privacy_heading;
            $page_data->privacy_content = $request->privacy_content;
            $page_data->privacy_status = $request->privacy_status;
            $page_data->update();

        return redirect()->back()->with('success', 'Privacy page has been updated successfully.');
    }

    public function contact()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_contact', compact('page_data'));
    }
    public function contact_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->contact_heading = $request->contact_heading;
            $page_data->contact_map = $request->contact_map;
            $page_data->contact_status = $request->contact_status;
            $page_data->update();

        return redirect()->back()->with('success', 'Contact page has been updated successfully.');
    }
    public function photo_gallery()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_photo_gallery', compact('page_data'));
    }
    public function photo_gallery_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->photo_gallery_heading = $request->photo_gallery_heading;
            $page_data->photo_gallery_status = $request->photo_gallery_status;
            $page_data->update();

        return redirect()->back()->with('success', 'Photo Gallery page has been updated successfully.');
    }
    public function video_gallery()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_video_gallery', compact('page_data'));
    }
    public function video_gallery_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->video_gallery_heading = $request->video_gallery_heading;
            $page_data->video_gallery_status = $request->video_gallery_status;
            $page_data->update();

        return redirect()->back()->with('success', 'Video Gallery page has been updated successfully.');
    }
    public function faq()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_faq', compact('page_data'));
    }
    public function faq_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->faq_heading = $request->faq_heading;
            $page_data->faq_status = $request->faq_status;
            $page_data->update();

        return redirect()->back()->with('success', 'FAQ page has been updated successfully.');
    }
    public function blog()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_blog', compact('page_data'));
    }
    public function blog_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->blog_heading = $request->blog_heading;
            $page_data->blog_status = $request->blog_status;
            $page_data->update();

        return redirect()->back()->with('success', 'Blog page has been updated successfully.');
    }
    public function room()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_room', compact('page_data'));
    }
    public function room_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->room_heading = $request->room_heading;
            $page_data->update();

        return redirect()->back()->with('success', 'Room page has been updated successfully.');
    }
    public function cart()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_cart', compact('page_data'));
    }
    public function cart_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->cart_heading = $request->cart_heading;
            $page_data->cart_status = $request->cart_status;
            $page_data->update();

        return redirect()->back()->with('success', 'Cart page has been updated successfully.');
    }
    public function checkout()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_checkout', compact('page_data'));
    }
    public function checkout_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->checkout_heading = $request->checkout_heading;
            $page_data->checkout_status = $request->checkout_status;
            $page_data->update();

        return redirect()->back()->with('success', 'Checkout page has been updated successfully.');
    }
    public function payment()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_payment', compact('page_data'));
    }
    public function payment_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->payment_heading = $request->payment_heading;
            $page_data->update();

        return redirect()->back()->with('success', 'Payment page has been updated successfully.');
    }
    public function signup()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_signup', compact('page_data'));
    }
    public function signup_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->signup_heading = $request->signup_heading;
            $page_data->signup_status = $request->signup_status;
            $page_data->update();

        return redirect()->back()->with('success', 'Signup page has been updated successfully.');
    }
    public function signin()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_signin', compact('page_data'));
    }
    public function signin_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->signin_heading = $request->signin_heading;
            $page_data->signin_status = $request->signin_status;
            $page_data->update();

        return redirect()->back()->with('success', 'Login page has been updated successfully.');
    }

    public function forget_password()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_forget_password', compact('page_data'));
    }
    public function forget_password_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->forget_password_heading = $request->forget_password_heading;
            $page_data->update();

        return redirect()->back()->with('success', 'Forget password page has been updated successfully.');
    }
    public function reset_password()
    {
        $page_data = Page::where('id', 1)->first();
        return view('admin.page_reset_password', compact('page_data'));
    }
    public function reset_password_update(Request $request) {
       $page_data = Page::where('id', 1)->first();
            $page_data->reset_password_heading = $request->reset_password_heading;
            $page_data->update();

        return redirect()->back()->with('success', 'Reset password page has been updated successfully.');
    }
}