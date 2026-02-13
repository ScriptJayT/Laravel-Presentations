<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;
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
        $all = Presentation::select(
            'id', 'title', 'slug',
            /** to allow eager loading to work when selecting, exact id's are required */
            'user_id', 'presentation_visibility_id', 'presentation_script_id',
        )
            ->with([
                /** always inlcude the id, as db doesn't otherwise now what to look against */
                'user' => fn ($q) => $q->select('id', 'name'),
                'presentationVisibility' => fn ($q) => $q->select('id', 'title', 'name'),
                'presentationScript' => fn ($q) => $q->select('id', 'title'),
            ])
            ->get()
            ->sortBy(
                callback: fn ($_presentation) => $_presentation->presentationVisibility->id,
                descending: true
            );

        $public = $all
            ->filter(fn ($_presentation) => $_presentation->presentationVisibility->title === 'public');
        $private = $all
            ->filter(fn ($_presentation) => $_presentation->presentationVisibility->title === 'login');
        $creator = $this->isLoggedIn()
            ? $all->filter(fn ($_presentation) => $this->loggedinIsCreator($_presentation))
            : [];

        return Inertia::render('presentation/Index', [
            'allPublicPresentations' => $public,
            'allPrivatePresentations' => $private,
            'allCreatorPresentations' => $creator,
            'isLoggedIn' => $this->isLoggedIn(),
        ]);
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
