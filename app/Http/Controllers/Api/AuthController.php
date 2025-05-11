<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\BaseApiController;
use Validator;

class AuthController extends BaseApiController
{
    public function login(Request $request)
    {
        $user = User::where("email", $request->email)->first();
        if (!isset($user)) {
            // return response()->json(['error' => ]);
            return $this->sendErrorResponse("Invalid Credentials.", 400);
        }
        if (!Hash::check($request->password, $user->password)) {
            return $this->sendErrorResponse("Invalid Credentials.", 400);
        }
        $credentials = $request->only('email', 'password');
        if (!$token = auth('api')->attempt($credentials)) {
            return $this->sendErrorResponse("Unauthorized access.", 401);
        }

        $data = [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            "user" => $user,
            "role" => $user->role()->first()->name,
            "role_id" => $user->role()->first()->id
        ];
        return $this->sendSuccessResponse($data, "User login successfully", 200);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }
}
