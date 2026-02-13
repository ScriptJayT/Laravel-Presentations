<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as IResponse;

class PresentationController extends Controller
{
    private function isLoggedIn(): bool
    {
        return auth()->check();
    }

    private function loggedinIsCreator(Presentation $_presentation): bool
    {
        if (! $this->isLoggedIn()) {
            return false;
        }

        return $_presentation->user->id === auth()->user()->id;
    }

    public function index(Request $_): IResponse
    {
        $all = Presentation::all()
            ->sortBy(
                callback: fn ($_presentation) => $_presentation->presentationVisibility->id,
                descending: true
            );
        $public = $all->filter(fn ($_presentation) => $_presentation->presentationVisibility->title === 'public');
        $private = $all->filter(fn ($_presentation) => $_presentation->presentationVisibility->title === 'login');
        $creator = $this->isLoggedIn()
            ? $all->filter(fn ($_presentation) => $this->loggedinIsCreator($_presentation))
            : new Collection([]);

        $props = [
            'allPublicPresentations' => (array) $public->all(),
            'allPrivatePresentations' => (array) $private->all(),
            'allCreatorPresentations' => (array) $creator->all(),
            'isLoggedIn' => $this->isLoggedIn(),
        ];

        return Inertia::render('presentation/Index', $props);
    }

    public function show(string $_presId): mixed
    {
        $presentation = Presentation::where('slug', $_presId)->with('slides')->first();
        $isAllowedFurter = match ($presentation->presentationVisibility->title) {
            'public' => true,
            'login' => $this->isLoggedIn(),
            'creator' => $this->loggedinIsCreator($presentation),
            default => false,
        };

        return $isAllowedFurter
            ? Inertia::render('presentation/Show', ['presentation' => $presentation])
            : Redirect::route('home');
    }
}
