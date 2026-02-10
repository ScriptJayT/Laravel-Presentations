<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class PresentationController extends Controller
{
    public function index(Request $_): Response
    {
        return Inertia::render('Welcome');
    }

    public function show(string $_presId): Response
    {
        $presentation = Presentation::where('slug', $_presId)->first();
        $isAllowedFurter = match ($presentation->presentationVisibility->title) {
            'login' => auth()->check(),
            'public' => true,
            'creator' => auth()->check() && (auth()->user()->id === $presentation->user->id),
            default => false,
        };
        if (! $isAllowedFurter) {
            Redirect::route('home');
            exit();
        }

        return Inertia::render('presentation/Show', ['presentation' => $presentation]);
    }

    public function edit(string $_presId): Response
    {
        $presentation = Presentation::find($_presId);

        return Inertia::render('dashboard/PresentationEdit', ['presentation' => $presentation]);
    }
}
