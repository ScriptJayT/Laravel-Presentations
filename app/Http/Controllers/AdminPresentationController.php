<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use App\Models\PresentationScript;
use App\Models\PresentationVisibility;
use Illuminate\Http\Request;
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
        $rules = PresentationVisibility::all(['title', 'name'])->all();
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
        dd($presentation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
