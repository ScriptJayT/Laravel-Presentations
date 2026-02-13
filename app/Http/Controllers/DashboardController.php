<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function show(Request $_): Response
    {
        $presentations = Presentation::all();

        return Inertia::render('dashboard/PresentationIndex', [
            'allPresentations' => $presentations,
        ]);
    }
}
