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
    public function index(Request $_): IResponse
    {
        return Inertia::render('dashboard/PresentationIndex', [
            'allPresentations' => Presentation::all(),
        ]);
    }

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
}
