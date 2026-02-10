<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as IResponse;

class PresentationController extends Controller
{
    public function index(Request $_): IResponse
    {
        return Inertia::render('Welcome');
    }

    public function show(string $_presId): mixed
    {
        $presentation = Presentation::where('slug', $_presId)->first();
        $isAllowedFurter = match ($presentation->presentationVisibility->title) {
            'login' => auth()->check(),
            'public' => true,
            'creator' => auth()->check() && (auth()->user()->id === $presentation->user->id),
            default => false,
        };
        if (! $isAllowedFurter) {
            return Redirect::route('home');
        }

        return Inertia::render('presentation/Show', ['presentation' => $presentation]);
    }

    public function edit(string $_presId): IResponse
    {
        $presentation = Presentation::find($_presId);

        return Inertia::render('dashboard/PresentationEdit', ['presentation' => $presentation]);
    }
}
