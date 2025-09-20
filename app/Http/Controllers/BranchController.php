<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index(){
        if(Auth::user()->hasRole("super-admin"))
        {
            $branches = Branch::withTrashed()->paginate(10);
        }
        else{
            $branches = Branch::paginate(10);
        }

        return view('dashboard.branches.index',['branches' => $branches]);
    }

    public function store(request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        if($request->has('edit_id') && $request->edit_id != '' || $request->edit_id != null ){
            $branch = Branch::find($request->edit_id);
            $msg = [
                'success' => 'Branch Updated Successfully',
                'reload' => true
            ];
        }
        else{
            $branch = new Branch();
            $msg = [
                'success' => 'Branch Created Successfully',
                'reload' => true
            ];
        }

        $branch->name = $request->name;
        $branch->address = $request->address;
        $branch->city = $request->city;
        $branch->phone = $request->phone;
        $branch->save();

        return response()->json($msg);
    }

    public function destroy($id){
        $branch = Branch::withTrashed()->find($id);
        if($branch)
        {
            // Soft delete related models
            $relations = [
                'users',
                'classes',
                'sections',
                'students',
                'courses',
                'courseSubjects',
                'attendances',
                'subjects',
                'teachers'
            ];

            foreach ($relations as $relation) {
                $branch->$relation()->withTrashed()->each(function ($item) {
                    if ($item->trashed()) {
                        $item->forceDelete(); // Permanently delete if it's soft-deleted
                    } else {
                        $item->delete(); // Soft delete if it's not trashed
                    }
                });
            }

         // Check if the Branch is soft-deleted
            if ($branch->trashed()) {
                $branch->forceDelete(); // Permanently delete the branch if it was already soft-deleted
                $msg = [
                    'success' => 'Branch Permanently Deleted Successfully',
                    'reload' => true
                ];
            } else {
                $branch->delete(); // Soft delete the branch if it's not trashed
                $msg = [
                    'success' => 'Branch Deleted Successfully',
                    'reload' => true
                ];
            }
            } else {
                $msg = ['error' => 'Branch Not Found'];
            }
            return response()->json($msg);
    }
}
