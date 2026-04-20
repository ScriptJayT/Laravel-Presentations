<?php

namespace App\Http\Controllers\Presentations;

use App\Http\Controllers\Controller;
use App\Models\PresentationSlide;
use App\Models\PresentationTheme;
use App\Traits\HasVisibilityRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminPresentationSlideController extends Controller
{
    use HasVisibilityRule;

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
            'order' => 'required|integer',
        ])->validated();

        $theme = PresentationTheme::select('id')->first();
        PresentationSlide::create([
            'presentation_id' => $validated['presentation'],
            'title' => e($validated['title']),
            'content' => '',
            'order' => $validated['order'],
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
        // $slide->load([
        //     'presentation.user' => fn ($q) => $q->select('id'),
        //     'presentation.presentationVisibility' => fn ($q) => $q->select('id', 'title'),
        // ]);
        $slide->load('presentation');

        $this->returnIfNotAllowed(
            _model: $slide->presentation,
            _useAbort: true,
        );

        $validated = validator($request->all(), [
            'title' => 'required|min:2',
            'content' => '',
            'order' => 'required|integer',
        ])->validated();

        $slide->title = $validated['title'];
        $slide->content = $validated['content'];
        $slide->order = $validated['order'];
        $slide->save();

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PresentationSlide $slide)
    {
        // $slide->load([
        //     'presentation.user' => fn ($q) => $q->select('id'),
        //     'presentation.presentationVisibility' => fn ($q) => $q->select('id', 'title'),
        // ]);
        $slide->load('presentation');

        $this->returnIfNotAllowed(
            _model: $slide->presentation,
            _useAbort: true,
        );

        if ($slide->delete()) {
            session()->flash('info', 'successfully deleted the slide');
        } else {
            session()->flash('error', 'something went wrong while deleting a slide');
        }

        return Redirect::back();
    }
}
