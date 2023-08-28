<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Validator;

class AuthController extends Controller
{
    /**
     * Login The User
     * @param Request $request
     * @return JsonResponse
     */
    public function loginUser(Request $request): JsonResponse
    {
        try {
            $validateUser = Validator::make($request->all(),
                [
                    'npk' => 'required',
                    'password' => 'required'
                ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['npk', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Username & Password does not match with our record.',
                ], 401);
            }

            $user = Users::where('npk', $request->npk)
                ->where('id_user_group', '4')->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user
            ]);

        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logoutUser(Request $request): JsonResponse
    {
        $deleted = $request->user()->tokens()->delete();
        if ($deleted) {
            return response()->json([
                'status' => true,
                'message' => 'Logout successfully'
            ], 200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Error when try to logout users'
        ], 500);
    }
}
