<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(){

        $roles = Role::paginate(10);

        $data = [
            'roles' => $roles
        ];
        return view('roles.index',$data);
    }

    public function store(request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        if($request->has('edit_id') && $request->edit_id != '' || $request->edit_id != null ){
            $role = Role::find($request->edit_id);

            if ($role) {
                // Update the role if found
                $role->name = $request->name;
                $role->save();

                $msg = [
                    'success' => 'Role Updated Successfully',
                    'reload' => true
                ];
            } else {
                // If role not found, return error
                return response()->json(['errors' => ['Role not found.']], 404);
            }
        }
        else{
            $role = Role::create(['name' => $request->name]);
            $msg = [
                'success' => 'Role Created Successfully',
                'reload' => true
            ];
        }


        return response()->json($msg);
    }


    public function destroy($id){
        $role = Role::find($id);
        if($role)
        {
            $role->delete();
            $msg = [
                'success' => 'Role Deleted Successfully',
                'reload' => true
            ];
        }
        else {
            $msg = ['error' => 'Role Not Found'];
        }
        return response()->json($msg);
    }




    public function givePermissions($id){
        $permissions = Permission::all();
        $role = Role::find($id); // Find the role by its ID
        $data = [
            'role_id' => $id,
            'groupedPermissions' => $permissions->groupBy('model'),
            'rolePermissions' => $role->permissions->pluck('id')->toArray()
        ];

        return view('givePermissions.index',$data);
    }

    public function applyPermissions(request $request){

        $role = role::find($request->role_id);

        $role->syncPermissions($request->permissions);
        $msg = [
            'success' => 'Permissions Applied Successfully',
            'reload' => true
        ];
        return response()->json($msg);

    }
}
