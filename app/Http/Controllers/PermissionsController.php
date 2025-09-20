<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PermissionsController extends Controller
{
    public function index(){
        $permissions = Permission::paginate(10);
        $data = [
            'permissions' => $permissions
        ];
        return view('permissions.index',$data);
    }

    public function store(request $request){

        $validator = Validator::make($request->all(), [
            'model' => 'required',
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        if($request->has('edit_id') && $request->edit_id != '' || $request->edit_id != null ){
            $permission = Permission::find($request->edit_id);

            if ($permission) {
                // Update the permission if found
                $permission->model = $request->model;
                $permission->name = $request->name;
                $permission->save();

                $msg = [
                    'success' => 'Permission Updated Successfully',
                    'reload' => true
                ];
            } else {
                // If Permission not found, return error
                return response()->json(['errors' => ['Permission not found.']], 404);
            }
        }
        else{
            $permission = Permission::create(['name' => $request->name, 'model' => $request->model]);
            $msg = [
                'success' => 'Permission Created Successfully',
                'reload' => true
            ];
        }


        return response()->json($msg);
    }


    public function destroy($id){
        $permission = Permission::find($id);
        if($permission)
        {
            $permission->delete();
            $msg = [
                'success' => 'Permission Deleted Successfully',
                'reload' => true
            ];
        }
        else {
            $msg = ['error' => 'Permission Not Found'];
        }


        return response()->json($msg);
    }

}


