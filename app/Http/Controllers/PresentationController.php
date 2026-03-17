<?php

namespace App\Http\Controllers;

use App\Enums\Visibility;
use App\Models\Presentation;
use App\Traits\HasVisibilityRule;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as IResponse;

class PresentationController extends Controller
{
    use HasVisibilityRule;

    public function index(Request $_): IResponse
    {
        $all = Presentation::select(
            'id', 'title', 'slug',
            /** to allow eager loading to work when selecting, exact id's are required */
            'user_id', 'presentation_visibility_id', 'presentation_script_id',
        )
            ->with(
                'user',
                'presentationVisibility',
                'presentationScript',
            )
            ->get()
            ->sortBy(
                callback: fn ($_p) => $_p->presentationVisibility->id,
                descending: true
            );

        $public = $all
            ->filter(fn ($_p) => $_p->presentationVisibility->title === Visibility::PUBLIC->title());
        $protected = $all
            ->filter(fn ($_p) => $_p->presentationVisibility->title === Visibility::PROTECTED->title());
        $creator = $this->isLoggedIn()
            ? $all->filter(fn ($_p) => $this->loggedinIsCreator($_p->user))
            : new Collection([]);

        return Inertia::render('presentation/Index', [
            'allPublicPresentations' => array_values($public->all()),
            'allPrivatePresentations' => array_values($protected->all()),
            'allCreatorPresentations' => array_values($creator->all()),
            'isLoggedIn' => $this->isLoggedIn(),
        ]);
    }

    public function show(Presentation $presentation): mixed
    {
        $presentation->load([
            'slides' => fn ($q) => $q->select(
                'id', 'presentation_id', 'title', 'content'
            ),
        ]);

        return $this->isAllowedFurter(
            _visibility: $presentation->presentationVisibility,
            _creator: $presentation->user
        )
            ? Inertia::render('presentation/Show', [
                'presentation' => $presentation,
            ])
            : Redirect::route('home');
    }
}
