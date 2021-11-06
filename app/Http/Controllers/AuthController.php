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

        $response = [];
        $error    = true;
        $code     = 401;

        try {
            $user = $userRepository->create($request);

            $error    = false;
            $code     = 201;
            $message  = 'User registration is successful';
            $response = Helper::userFormattedResponse($user);

        } catch (Exception $exception) {
            $message = $exception->getMessage();
        }


        return response()->json([
            'error' => $error,
            'message' => $message,
            'response' => $response
        ], $code);
    }


    public function login(Request $request, UserRepository $userRepository)
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


        $error = true;
        $code  = 401;
        $token = null;

        try {
            if (!JWTAuth::attempt($credentials)) {
                $message = 'Email or Password doesn\'t match';
            } else {
                $error              = false;
                $code               = 200;
                $message            = 'User is logged in successfully';
                $authenticated_user = auth()->user();
                $token              = auth()->tokenById($authenticated_user->uuid);
                $user               = Helper::userFormattedResponse($authenticated_user);
            }
        } catch (Exception $exception) {
            $message = $exception->getMessage();
        }

        return response()->json([
            'error' => $error,
            'message' => $message,
            'response' => [
                'user' => $user,
                'token' => $token,
            ]
        ], $code);
    }


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
