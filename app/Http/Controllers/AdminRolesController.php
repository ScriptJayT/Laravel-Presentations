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
            'canEdit' => $request->user()->can('primordial'),
        ]);
    }

    public function edit(Role $role)
    {
        $role->load('permissions');

        return Inertia::render('dashboard/model-roles/Edit', ['role' => $role]);
    }

    public function update(Request $request, Role $role)
    {
        $descr = e($request->all('description')['description']);
        $role->description = trim($descr);
        if ($role->save()) {
            session()->flash('Role description edited successfully');
        } else {
            session()->flash('Something went wrong editing a role description');
        }

        return Redirect::route('admin_role_index');
    }
}
