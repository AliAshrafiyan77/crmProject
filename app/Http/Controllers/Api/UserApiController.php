<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserApiController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Request logout
     *
     * @return JsonResponse|JsonResponse
     */
    public function logout()
    {
        try {
            $this->userService->logout();
        }
        catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to log out. ' . $e->getMessage()
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ], 200);

    }
}
