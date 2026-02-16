<?php

namespace App\Http\Controllers;

use App\Models\PresentationScript;
use Inertia\Inertia;

class PresentationScriptController extends Controller
{
    public function show(string $_presId): mixed
    {
        $script = PresentationScript::where('id', $_presId)->first();

        return Inertia::render('script/Show', ['script' => $script]);
    }
}
