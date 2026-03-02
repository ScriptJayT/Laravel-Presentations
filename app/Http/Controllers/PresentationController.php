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
            ->filter(fn ($_presentation) => $_presentation->presentationVisibility->title === Visibility::PUBLIC->title());
        $protected = $all
            ->filter(fn ($_presentation) => $_presentation->presentationVisibility->title === Visibility::PROTECTED->title());
        $creator = $this->isLoggedIn()
            ? $all->filter(fn ($_presentation) => $this->loggedinIsCreator($_presentation->user))
            : new Collection([]);

        return Inertia::render('presentation/Index', [
            'allPublicPresentations' => array_values($public->all()),
            'allPrivatePresentations' => array_values($protected->all()),
            'allCreatorPresentations' => array_values($creator->all()),
            'isLoggedIn' => $this->isLoggedIn(),
        ]);
    }

    public function show(string $_presId): mixed
    {
        $presentation = Presentation::where('slug', $_presId)->with('slides')->first();

        return $this->isAllowedFurter(
            _visibility: $presentation->presentationVisibility,
            _creator: $presentation->user
        )
            ? Inertia::render('presentation/Show', ['presentation' => $presentation])
            : Redirect::route('home');
    }
}
