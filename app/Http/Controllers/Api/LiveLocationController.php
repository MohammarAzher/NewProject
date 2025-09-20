<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LiveLocation;
use App\Events\LiveLocationUpdated;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LiveLocationController extends Controller
{
    public function update(Request $request)
    {



         //valid credential
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }



        $user = JWTAuth::parseToken()->authenticate();
        $location = LiveLocation::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'latitude'     => $request->latitude,
                'longitude'    => $request->longitude,
            ]
        );

        // Load relations for broadcasting
        $location->load('user.areas');

        broadcast(new LiveLocationUpdated($location))->toOthers();

        return response()->json(['status' => 'success']);
    }
}
