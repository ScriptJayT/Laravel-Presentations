<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Models\PresentationScript;
use App\Models\PresentationVisibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response as IResponse;

class AdminPresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $_): IResponse
    {
        return Inertia::render('dashboard/PresentationIndex', [
            'allPresentations' => Presentation::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $_presId): IResponse
    {
        $presentation = Presentation::where('id', $_presId)->with('slides')->first();
        $rules = PresentationVisibility::all(['id', 'name'])->all();
        $scripts = PresentationScript::all(['id', 'title'])->all();

        return Inertia::render('dashboard/PresentationEdit', [
            'presentation' => $presentation,
            'rules' => $rules,
            'scripts' => $scripts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    // public function show(string $id) { }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Presentation $presentation)
    {
        $validated = validator($request->all(), [
            'title' => 'required|min:2',
            'slug' => 'required|min:2',
            'visibility' => 'required|exists:presentation_visibilities,id',
            'script' => '',
        ])->validated();

        $slug = Str::slug($validated['slug']);
        $validated['slug'] = $slug;
        if ($presentation->slug !== $slug) {
            validator(['slug' => $slug], [
                'slug' => 'unique:presentations,slug',
            ])->validated();
        }
        $script = $validated['script'];
        if (! is_null($script)) {
            validator(['script' => $script], [
                'script' => 'exists:presentation_scripts,id',
            ])->validated();
        }

        $presentation->title = e($validated['title']);
        $presentation->slug = $validated['slug'];
        $presentation->presentation_script_id = $validated['script'];
        $presentation->presentation_visibility_id = $validated['visibility'];
        $presentation->save();

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Presentation::whereId($id)->delete()) {
            session()->flash('info', 'successfully deleted the presentation');
        } else {
            session()->flash('error', 'something went wrong while deleting a presentation');
        }

        return Redirect::route('admin_presentation_index');
    }
}
