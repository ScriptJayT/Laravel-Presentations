<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRolesController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('dashboard/model-roles/Index', [
            'allRoles' => Role::all('id', 'name', 'description'),
            'allPermissions' => Permission::all('id', 'name', 'description'),
        ]);
    }

    public function edit(Role $role)
    {
        $role->load('permissions');

        return Inertia::render('dashboard/model-roles/Edit', ['role' => $role]);
    }

    public function update(Request $request, Role $role)
    {
        dd($request->all());

        return Redirect::back();
    }
}
