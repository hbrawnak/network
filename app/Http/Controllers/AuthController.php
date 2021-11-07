<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Repository\UserRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class AuthController extends Controller
{


    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function register(Request $request, UserRepository $userRepository): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|min:3|max:50',
            'last_name' => 'required|string|min:3|max:50',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => $validator->errors()
            ], 401);
        }

        try {
            $user = $userRepository->create($request);
            return response()->json([
                'error' => false,
                'message' => 'User registration is successful',
                'response' => Helper::userFormattedResponse($user)
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage(),
                'response' => []
            ], 401);
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => 'Data validation error',
                'response' => $validator->errors()
            ], 401);
        }

        try {
            if (!JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Email or Password doesn\'t match',
                    'response' => []
                ], 401);
            }
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage(),
                'response' => []
            ], 401);
        }

        $authenticated_user = auth()->user();
        $token              = auth()->tokenById($authenticated_user->id);
        $user               = Helper::userFormattedResponse($authenticated_user);

        return response()->json([
            'error' => false,
            'message' => 'User is logged in successfully',
            'response' => [
                'user' => $user,
                'token' => $token,
            ]
        ], 200);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->header('Authorization');

        try {
            JWTAuth::invalidate($token);
            return response()->json([
                'error' => false,
                'message' => 'Successfully logged out',
                'response' => []
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage(),
                'response' => []
            ], 401);
        }
    }


}
