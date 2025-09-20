<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                 'success' => false,
                 'message' => 'Login credentials are invalid.',
                ], 400);
            }
            $user = JWTAuth::user();

          $areas = $user->areas->map(function ($area) {
                return [
                    'id' => $area->id,
                    'name' => $area->name
                ];
            });

            // $role = $user->roles->pluck('name')->first(); // Get first role name



        } catch (JWTException $e) {
            return $credentials;
            return response()->json([
                 'success' => false,
                 'message' => 'Could not create token.',
                ], 500);
        }

   //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'user' => $user->makeHidden('areas'), // hides tappas from user object
            'areas' => $areas,
            // 'role' => $role,
            'token' => $token,
        ]);
    }
}
