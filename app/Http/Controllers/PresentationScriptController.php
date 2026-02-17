<?php

namespace App\Http\Controllers;

use App\Models\PresentationScript;
use Inertia\Inertia;

class PresentationScriptController extends Controller
{
    public function show(PresentationScript $script): mixed
    {
        return Inertia::render('script/Show', ['script' => $script]);
    }
}
