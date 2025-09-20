<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

class ProfileController extends Controller
{
    public function index(){
        return view('dashboard.profile');
    }

    public function update(request $request){

        if($request->has('old_password'))
        {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required',
                'new_password' => 'required',
                'c_password' => 'required|same:new_password',
            ], [
                'c_password.same' => 'The confirmation password does not match.',
            ]);
            if ($validator->fails()) {
                return ['errors' => $validator->errors()];
            }

            $user = User::find($request->edit_id);
            if (!(Hash::check($request->old_password, $user->password))) {
                return response()->json([
                    'error' => __('Please Enter Correct Current Password'),
                ]);
            }else{
                $user->password = Hash::make($request->new_password);
                $user->save();
                $msg = [
                    'success' => 'Password Updated Successfully',
                    'reload' => true
                ];
                return response()->json($msg);
            }
        }
        else
        {
            $rules = [
                'username' => 'required',
                'email' => 'required|email|unique:users,email,'.$request->edit_id,
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return ['errors' => $validator->errors()];
            }
            $user =  user::find($request->edit_id);
            $user->name = $request->username;
            $user->email = $request->email;

            if ($request->hasFile('profile_image')) {
                $profile_image = uploadSingleFile($request->file('profile_image'), 'uploads/admins/profile/','png,jpeg,jpg');
                if (is_array($profile_image)) {
                    return response()->json($profile_image);
                }
                if (file_exists($user->image)) {
                    @unlink($user->image);
                }
                $user->image = $profile_image;
            }

            $user->save();
        }

        $msg = [
            'success' => 'Profile Updated Successfully',
            'reload' => true
        ];
        return response()->json($msg);
}
}
