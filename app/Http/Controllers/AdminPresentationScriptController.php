<?php

namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Models\PresentationScript;
use App\Models\PresentationVisibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as IResponse;

class AdminPresentationScriptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): IResponse
    {
        return Inertia::render('dashboard/model-script/Index', [
            'allScripts' => PresentationScript::all(),
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
            'title' => 'required|min:5|unique:presentation_scripts,title',
            'goto' => '',
        ])->validated();
        $visibility = PresentationVisibility::where('title', Visibility::PROTECTED->title())->first();
        $script = PresentationScript::create([
            'title' => e($validated['title']),
            'content' => '',
            'presentation_visibility_id' => $visibility->id,
        ]);

        if ($validated['goto'] ?? '' === 'on') {
            session()->flash('info', 'new script created');

            return Redirect::route('admin_scripts', $script->id);
        }

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id) { }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PresentationScript $script)
    {
        $script->load([
            // need the presentation_script_id for it to work
            'presentations' => fn ($q) => $q->select('presentation_script_id', 'id', 'title'),
        ]);

        return Inertia::render('dashboard/model-script/Edit', [
            'script' => $script,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PresentationScript $script)
    {
        $validated = validator($request->all(), [
            'title' => 'required|min:2',
            'content' => '',
        ])->validated();
        $script->title = e($validated['title']);
        $script->content = e($validated['content']);
        $script->save();

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (PresentationScript::whereId($id)->delete()) {
            session()->flash('info', 'successfully deleted the script');
        } else {
            session()->flash('error', 'something went wrong while deleting a script');
        }

        return Redirect::route('admin_script_index');
    }
}
