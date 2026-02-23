<?php

namespace App\Http\Controllers;

use App\Models\PresentationSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminPresentationSlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    // public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());

        $validated = validator($request->all(), [
            'title' => 'required|min:5|unique:presentation_scripts,title',
        ])->validated();
        $slide = PresentationSlide::create([
            'title' => e($validated['title']),
            'content' => '',
        ]);

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id) { }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit() {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PresentationSlide $slide)
    {
        dd($request->all());

        $validated = validator($request->all(), [
            'title' => 'required|min:2',
            'content' => '',
        ])->validated();
        $slide->title = e($validated['title']);
        $slide->content = e($validated['content']);
        $slide->save();

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd($id);

        if (PresentationSlide::whereId($id)->delete()) {
            session()->flash('info', 'successfully deleted the slide');
        } else {
            session()->flash('error', 'something went wrong while deleting a slide');
        }

        return Redirect::back();
    }
}
