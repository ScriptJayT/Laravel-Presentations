<?php

namespace App\Http\Controllers;

use App\Models\PresentationScript;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as IResponse;

class AdminPresentationScriptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): IResponse
    {
        return Inertia::render('dashboard/PresentationScriptIndex', [
            'allScripts' => PresentationScript::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        return Inertia::render('dashboard/PresentationScriptEdit', [
            'script' => $script,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
