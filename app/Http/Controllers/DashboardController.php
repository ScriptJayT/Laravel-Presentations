<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Presentation;

class DashboardController extends Controller
{
    public function show(Request $_): Response
    {
        $presentations = Presentation::all();
        return Inertia::render('dashboard/Index', [
            'allPresentations' => $presentations,
        ]);
    }
}
