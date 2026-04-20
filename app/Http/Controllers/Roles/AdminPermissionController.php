<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class AdminPermissionController extends Controller
{
    public function edit(Permission $permission)
    {
        return Inertia::render('dashboard/model-permission/Edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
        $descr = e($request->all('description')['description']);
        $permission->description = trim($descr);
        if ($permission->save()) {
            session()->flash('info', 'Permission description edited successfully');
        } else {
            session()->flash('info', 'Something went wrong editing a permission description');
        }

        return Redirect::route('admin_role_index');
    }
}
