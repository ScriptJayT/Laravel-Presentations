<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Models\PresentationScript;
use App\Models\PresentationTheme;
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
        $all = Presentation::select(
            'id', 'title', 'slug', 'updated_at',
            /** to allow eager loading to work when selecting, exact id's are required */
            'user_id', 'presentation_visibility_id', 'presentation_script_id',
        )
            ->with([
                /** always inlcude the id, as db doesn't otherwise now what to look against */
                'user' => fn ($q) => $q->select('id', 'name'),
                'presentationVisibility' => fn ($q) => $q->select('id', 'title', 'name'),
                'presentationScript' => fn ($q) => $q->select('id', 'title'),
            ])
            ->get();

        return Inertia::render('dashboard/model-presentation/Index', [
            'allPresentations' => $all,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $_presId): IResponse
    {
        $presentation = Presentation::where('id', $_presId)
            ->with(['slides' => fn ($q) => $q->orderBy('order', 'desc')])
            ->first();
        $rules = PresentationVisibility::all(['id', 'name'])->all();
        $scripts = PresentationScript::all(['id', 'title'])->all();

        return Inertia::render('dashboard/model-presentation/Edit', [
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
    public function store(Request $request)
    {
        $validated = validator($request->all(), [
            'title' => 'required|min:2',
            'goto' => '',
        ])->validated();
        $slug = Str::slug($validated['title']);
        validator(['slug' => $slug], [
            'slug' => 'required|min:2|unique:presentations,slug',
        ])->validated();

        $user = $request->user();
        $visibility = PresentationVisibility::where('title', 'creator')->first();
        $theme = PresentationTheme::where('id', '1')->first();
        $script = null;

        $presentation = Presentation::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'user_id' => $user->id,
            'presentation_visibility_id' => $visibility->id,
            'presentation_theme_id' => $theme->id,
            'presentation_script_id' => $script,
        ]);

        if ($validated['goto'] ?? '' === 'on') {
            session()->flash('info', 'new presentation created');

            return Redirect::route('admin_presentations', $presentation->id);
        }

        return Redirect::back();
    }

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
