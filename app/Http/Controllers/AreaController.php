<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;


class AreaController extends Controller
{
    public function index(){

        $areas = Area::paginate(10);
        return view('areas.index',['areas' => $areas]);
    }

    public function store(request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return ['errors' => $validator->errors()];
        }

        if($request->has('edit_id') && $request->edit_id != '' || $request->edit_id != null ){
            $area = Area::find($request->edit_id);
            $msg = [
                'success' => 'Area Updated Successfully',
                'reload' => true
            ];
        }
        else{
            $area = new Area();
            $msg = [
                'success' => 'Area Created Successfully',
                'reload' => true
            ];
        }

        $area->name = $request->name;
        $area->save();

        return response()->json($msg);
    }


}
