<?php

namespace App\Http\Controllers;

use App\Models\PresentationScript;
use Inertia\Inertia;

class PresentationScriptController extends Controller
{
    public function show(string $_presId): mixed
    {
        // *todo: add visibility rule to scripts
        $script = PresentationScript::where('id', $_presId)->first();

        return Inertia::render('script/Show', ['script' => $script]);
    }
}
