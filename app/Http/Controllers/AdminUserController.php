<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('dashboard/model-user/Index', [
            'allUsers' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // the CreateNewUser class handles all validation; so we can pass all params to it
        (new CreateNewUser)->create($request->all());

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load([
            'presentations' => fn ($q) => $q->select('user_id', 'id', 'title'),
        ]);

        return Inertia::render('dashboard/model-user/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        abort(403, 'You have no access to this');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(403, 'You have no access to this');
    }
}
