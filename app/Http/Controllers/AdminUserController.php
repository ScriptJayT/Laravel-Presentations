<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class AdminUserController extends Controller
{
    use ProfileValidationRules;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('dashboard/model-user/Index', [
            'allUsers' => User::all(['id', 'name']),
            'canAdd' => $request->user()->can('create users'),
            'canEdit' => $request->user()->can('update users'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404, '>> This does not exist');
    }

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
    public function show(User $user, Request $req)
    {
        $user->load([
            'presentations',
            'presentationScripts',
            'roles' => fn ($_q) => $_q->select('id', 'name'),
            'roles.permissions' => fn ($_q) => $_q->select('id', 'name'),
        ]);

        return Inertia::render('dashboard/model-user/Show', [
            'user' => $user,
            'canEdit' => $req->user()->can('delete users'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, Request $req)
    {
        $user->load([
            'presentations',
            'presentationScripts',
            'roles' => fn ($_q) => $_q->select('id', 'name'),
            'roles.permissions' => fn ($_q) => $_q->select('id', 'name'),
        ]);

        return Inertia::render('dashboard/model-user/Edit', [
            'user' => $user,
            'canDelete' => $req->user()->can('delete users'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($user->hasRole('goddess', 'bot')) {
            return Redirect::route('admin_user_index')
                ->with('info', "bots or goddesses can't be edited");
        }

        $emailRemainsValidated = $user->email === $request->all('email');
        $validated = validator($request->all(), $this->profileRules($user->id))->validate();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (! $emailRemainsValidated) {
            $user->email_verified_at = null;
        }

        if ($user->save()) {
            session()->flash('info', 'successfully updated the user');
        } else {
            session()->flash('error', 'something went wrong while updating a user');
        }

        return Redirect::route('admin_user.show', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->hasAnyRole('goddess', 'bot')) {
            return Redirect::route('admin_user_index')->with('info', "bots or goddesses can't be deleted");
        }

        if ($user->delete()) {
            session()->flash('info', 'successfully deleted the user');
        } else {
            session()->flash('error', 'something went wrong while deleting a user');
        }

        return Redirect::route('admin_user_index');
    }
}
