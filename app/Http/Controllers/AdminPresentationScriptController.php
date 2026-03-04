<?php

namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Models\PresentationScript;
use App\Models\PresentationVisibility;
use App\Traits\HasVisibilityRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as IResponse;

class AdminPresentationScriptController extends Controller
{
    use HasVisibilityRule;

    /**
     * Display a listing of the resource.
     */
    public function index(): IResponse
    {
        $all = PresentationScript::select(
            'id', 'title', 'updated_at',
            /** to allow eager loading to work when selecting, exact id's are required */
            'user_id',
            'presentation_visibility_id',
        )
            ->with([
                /** always inlcude the id, as db doesn't otherwise now what to look against */
                'user' => fn ($q) => $q->select('id', 'name'),
                'presentationVisibility' => fn ($q) => $q->select('id', 'title', 'name'),
            ])
            ->get();

        return Inertia::render('dashboard/model-script/Index', [
            'allScripts' => $all,
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
        $visibility = PresentationVisibility::select('id')
            ->where('title', Visibility::PROTECTED->title())
            ->first();
        $script = PresentationScript::create([
            'title' => e($validated['title']),
            'content' => '',
            'presentation_visibility_id' => $visibility->id,
            'user_id' => $request->user()->id,
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
        if ($notAllowedRedirect = $this->returnIfNotAllowed(
            $script,
            "You're not the creator, you're not allowed to edit this",
            'admin_script_index'
        )) {
            return $notAllowedRedirect;
        }

        $script->load([
            // need the presentation_script_id for load to work
            'presentations' => fn ($q) => $q->select('presentation_script_id', 'id', 'title'),
        ]);
        $rules = PresentationVisibility::all(['id', 'name'])->all();

        return Inertia::render('dashboard/model-script/Edit', [
            'script' => $script,
            'rules' => $rules,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PresentationScript $script)
    {
        if ($notAllowedRedirect = $this->returnIfNotAllowed(
            $script,
            "You're not the creator, you're not allowed to update this",
            'admin_script_index'
        )) {
            return $notAllowedRedirect;
        }

        $validated = validator($request->all(), [
            'title' => 'required|min:2',
            'content' => '',
            'visibility' => 'required|exists:presentation_visibilities,id',
        ])->validated();
        $script->title = e($validated['title']);
        $script->content = e($validated['content']);
        $script->presentation_visibility_id = $validated['visibility'];
        $script->save();

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PresentationScript $script)
    {
        if ($notAllowedRedirect = $this->returnIfNotAllowed(
            $script,
            "You're not the creator, you're not allowed to delete this",
            'admin_script_index'
        )) {
            return $notAllowedRedirect;
        }

        if ($script->delete()) {
            session()->flash('info', 'successfully deleted the script');
        } else {
            session()->flash('error', 'something went wrong while deleting a script');
        }

        return Redirect::route('admin_script_index');
    }
}
