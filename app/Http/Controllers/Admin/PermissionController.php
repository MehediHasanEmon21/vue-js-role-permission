<?php

namespace App\Http\Controllers\Admin;

use App\Model\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function add_permission(Request $request)
    {


        Permission::create($request->all());
    }

    public function all_permission()
    {

        $permissions = Permission::with(['role'])->orderBy('id', 'DESC')->paginate(8);
        return response()->json(['permissions' => $permissions]);
    }

    public function edit_permission($id)
    {

        $permission = Permission::where('id', $id)->first();
        return response()->json(['permission' => $permission]);
    }

    public function update_permission(Request $request)
    {

        $permission = Permission::find($request->id);
        $permission->update($request->all());
    }

    public function delete_permission($id)
    {
        $permission = Permission::where('id', $id)->first();
        $permission->delete();
    }
}
