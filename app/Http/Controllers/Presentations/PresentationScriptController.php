<?php

namespace App\Http\Controllers\Presentations;

use App\Http\Controllers\Controller;
use App\Models\PresentationScript;
use App\Traits\HasVisibilityRule;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PresentationScriptController extends Controller
{
    use HasVisibilityRule;

    public function show(PresentationScript $script): mixed
    {
        return $this->isAllowedFurter(
            _visibility: $script->presentationVisibility,
            _creator: $script->user
        )
            ? Inertia::render('script/Show', [
                'script' => $script,
                'isLoggedIn' => $this->isLoggedIn(),
            ])
            : Redirect::route('home');
    }
}
