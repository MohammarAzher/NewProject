<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Area;
use Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super-admin');
            });

            return DataTables::of($users)
                ->addColumn('areas', function ($user) {
                    return $user->areas->map(function ($area) {
                        return '<span class="badge bg-primary">'.$area->name.'</span>';
                    })->implode(' ');
                })
                ->addColumn('role', function ($user) {
                    return $user->roles->map(function ($role) {
                        return '<span class="badge bg-success">'.$role->name.'</span>';
                    })->implode(' ');
                })
                ->addColumn('actions', function ($row) {
                    return '
                        <a href="'.route('user.edit', $row->id).'" class="btn btn-sm btn-primary">Edit</a>
                    ';
                })
                ->rawColumns(['role','areas', 'actions'])
                ->make(true);
        }

        return view('users.index');
    }

    public function create(){
        $areas = Area::select('id', 'name')->get();
        $roles = Role::where('name','!=','super-admin')->select('id', 'name')->get();
        $data = [
            'roles' => $roles,
            'areas' => $areas
        ];
        return view('users.create',$data);
    }

    public function edit($id){
        $user = User::find($id);
        $areas = Area::select('id', 'name')->get();
        $roles = Role::where('name','!=','super-admin')->select('id', 'name')->get();

        $data = [
            'user' => $user,
            'roles' => $roles,
            'areas' => $areas
        ];
        return view('users.create',$data);
    }

    public function store(request $request){

        $validator = Validator::make($request->all(), [
            'area_id' => 'required|array', // Multiple areas
            'area_id.*' => 'exists:areas,id', // Validate each area exists
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$request->edit_id,
            'designation' => 'required',
            'password' => 'required|same:c_password',
        ],
        $custom_messages = [
            'c_password.same' => 'The confirmation password does not match.',
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        if($request->has('edit_id') && $request->edit_id != '' || $request->edit_id != null ){
            $user = User::find($request->edit_id);
            $msg = [
                'success' => 'User Updated Successfully',
                'reload' => true
            ];
        }
        else{
            $user = new User();
            $msg = [
                'success' => 'User Created Successfully',
                'reload' => true
            ];
        }

        // Assign areas with role

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->designation = $request->designation;
        $user->cnic = $request->cnic;
        $user->mobile = $request->mobile;
        $user->code = $request->code;
        $user->joining_date = $request->joining_date;

        if ($request->hasFile('image')) {
            $image = uploadSingleFile($request->file('image'), 'uploads/users/profile/','png,jpeg,jpg');
            if (is_array($image)) {
                return response()->json($image);
            }
            if (file_exists($user->image)) {
                @unlink($user->image);
            }
            $user->image = $image;
        }




        $user->save();
        $user->syncRoles($request->role);
        $user->areas()->sync($request->area_id);

        return response()->json($msg);
    }


    public function status_update(request $request){
        $user = user::find($request->id);
        if($user->status == 1){
            $user->status = 0;
        }
        else{
            $user->status = 1;
        }
        $user->save();
        return response()->json($user->status);
    }
}
