<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class AdminFaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('admin.faq_view', compact('faqs'));
    }
    public function add()
    {
        return view('admin.faq_add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|min:5',
            'answer' => 'required|min:5',
        ]);

            Faq::create([
                'question' => $request->question,
                'answer' => $request->answer
            ]);
        return redirect()->back()->with('success', 'Faq has been added successfully.');

    }
    public function edit($id)
    {
        $faq_data = Faq::findOrFail($id);
        return view('admin.faq_edit', compact('faq_data'));
    }

    public function update(Request $request, $id)
    {
        $faq_data = Faq::findOrFail($id);
             $faq_data->question = $request->question;
             $faq_data->answer = $request->answer;
             $faq_data->update();

        return redirect()->back()->with('success', 'Faq has been updated successfully.');


    }

    public function destroy($id)
    {
        $faq_data = Faq::findOrFail($id);
        $faq_data->delete();
        return redirect()->back()->with('success', 'Faq has been deleted successfully.');


    }
}