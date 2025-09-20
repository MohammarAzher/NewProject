<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\User;


class LiveLocationController extends Controller
{
    public function index()
    {
        $areas = Area::all(); // For IBC dropdown
        return view('liveLocations.index', compact('areas'));
    }

    public function liveTracking(Request $request)
    {
        $query = User::select(['id','name','code'])->with(['latestLiveLocation','areas:id,name'])
        ->whereHas('areas', function ($q) use ($request) {
            if ($request->filled('area_id')) {
                $q->where('areas.id', $request->area_id);
            }
        });

        $users = $query->get()->map(function($user) {
            $user->areas->makeHidden('pivot');
            return $user;
        });

        return response()->json($users);
    }


}
