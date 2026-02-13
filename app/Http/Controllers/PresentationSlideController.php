<?php

namespace App\Http\Controllers;

use App\Models\PresentationSlide;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as IResponse;

class PresentationSlideController extends Controller
{
    public function index(Request $_): IResponse
    {
        $props = [
            'all' => PresentationSlide::all(),
        ];

        return Inertia::render('dashboard/PresentationSlideIndex', $props);
    }

    public function edit(string $_presId): IResponse
    {
        $presentation = PresentationSlide::where('id', $_presId)->with('slides')->first();

        return Inertia::render('dashboard/PresentationSlideEdit', [
            'presentation' => $presentation,
        ]);
    }
}
