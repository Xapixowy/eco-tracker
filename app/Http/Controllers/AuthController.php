<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function register(AuthRequest $request): JsonResponse
    {
        $registeredUser = $this->service->register($request->all());

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $registeredUser
        ], 201);
    }

    public function login(AuthRequest $request): JsonResponse
    {
        $token = $this->service->login($request->all());

        return response()->json([
            'message' => 'User logged in successfully',
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->service->logout($request->user());

        return response()->json([
            'message' => 'User logged out successfully',
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'User data retrieved successfully',
            'data' => $request->user()
        ]);
    }
}
