<?php

namespace App\Http\Controllers;

use App\Models\Presentation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PresentationController extends Controller
{
    public function index(Request $_): Response
    {
        return Inertia::render('Welcome');
    }
    public function show(Presentation $_pres): Response
    {
        return Inertia::render('Welcome');
    }

    public function edit(Presentation $_pres): Response
    {
        dd($_pres);
        return Inertia::render('Welcome');
    }
}
