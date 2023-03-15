<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

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
			$validateUser = \Validator::make($request->all(),
				[
					'username' => 'required',
					'password' => 'required'
				]);

			if ($validateUser->fails()) {
				return response()->json([
					'status' => false,
					'message' => 'validation error',
					'errors' => $validateUser->errors()
				], 401);
			}

			if (!\Auth::attempt($request->only(['username', 'password']))) {
				return response()->json([
					'status' => false,
					'message' => 'Username & Password does not match with our record.',
				], 401);
			}

			$user = Users::where('username', $request->username)
				->where('id_user_group', '4')->first();

			return response()->json([
				'status' => true,
				'message' => 'User Logged In Successfully',
				'token' => $user->createToken("API TOKEN")->plainTextToken
			]);

		} catch (Throwable $th) {
			return response()->json([
				'status' => false,
				'message' => $th->getMessage()
			], 500);
		}
	}
}
