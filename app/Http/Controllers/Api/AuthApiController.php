<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Support\Facades\Http;

class AuthApiController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register users
     * //     * @param Request $request
     * //     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validation = $this->authService->validate_registration($request->all());

        if (!$validation['success']) {
            $response = [
                'status' => 'error',
                'message' => $validation['errors'],
            ];
            return response()->json($response, 200);
        }

        $validated_data = $validation['request'];

        try {

            $user = $this->authService->register($validated_data);
            info($user->email);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create user. ' . $e->getMessage()
            ], 200);
        }

        $response = Http::post('http://127.0.0.1:8000/oauth/token', [
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
            'username' => $validated_data['email'],
            'password' => $validated_data['password'],
            'scope' => '*',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => $user,
            'token' => $response->json(),

        ], 200);

    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     * @throws Exception
     */
    public function login(Request $request)
    {
        $validation = $this->authService->validate_login($request->all());

        if (!$validation['success']) {

            return response()->json([
                'status' => 'error',
                'message' => $validation['errors'],
            ], 200);
        }

        $validated_data = $validation['request'];

        return $this->authService->login($validated_data);

    }


    public function refreshToken(Request $request)
    {
        $validation = $this->authService->validate_refresh_token($request->all());

        if(!$validation['success']){

            return response()->json([
                'status' => 'error',
                'message' => $validation['errors'],
            ], 200);
        }

        $validated_data = $validation['request'];

        return $this->authService->refresh_token($validated_data);

    }
}
