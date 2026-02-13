<?php

namespace App\Http\Controllers;

use App\Models\PresentationScript;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as IResponse;

class AdminPresentationScriptController extends Controller
{
    public function index(Request $_): IResponse
    {
        return Inertia::render('dashboard/PresentationScriptIndex', [
            'allScripts' => PresentationScript::all(),
        ]);
    }

    public function edit(string $_presId): IResponse
    {
        $script = PresentationScript::where('id', $_presId)->first();

        return Inertia::render('dashboard/PresentationScriptEdit', [
            'script' => $script,
        ]);
    }
}
