<?php

namespace App\Http\Controllers;

use App\Models\PresentationSlide;
use App\Models\PresentationTheme;
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
        $validated = validator($request->all(), [
            'title' => 'required|min:2|unique:presentation_scripts,title',
            'presentation' => 'required|integer|exists:presentations,id',
        ])->validated();

        $theme = PresentationTheme::where('id', '1')->first();
        PresentationSlide::create([
            'presentation_id' => $validated['presentation'],
            'title' => e($validated['title']),
            'content' => '',
            'order' => 0,
            'presentation_theme_id' => $theme->id,
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
        $validated = validator($request->all(), [
            'title' => 'required|min:2',
            'content' => '',
            'order' => 'required|integer',
        ])->validated();

        $slide->title = e($validated['title']);
        $slide->content = $validated['content'];
        $slide->order = $validated['order'];
        $slide->save();

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (PresentationSlide::whereId($id)->delete()) {
            session()->flash('info', 'successfully deleted the slide');
        } else {
            session()->flash('error', 'something went wrong while deleting a slide');
        }

        return Redirect::back();
    }
}
