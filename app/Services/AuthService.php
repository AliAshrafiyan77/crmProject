<?php


namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * @param array $request
     * @return array
     */
    public function validate_registration(array $request){
        $validator = Validator::make($request, [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ];
        }
        $sanitized_data = GeneralService::sanitize_data($request);//تمیز سازی داده های از عوامل مخرب

        return [
            'success' => true,
            'request' => $sanitized_data,
        ];
    }
    /**
     * @param array $data
     * @return User
     * @throws Exception
     */
    public function register(array $data): User
    {
        return $this->userRepository->register_user($data);
    }

    /**
     * @param array $request
     * @return array
     */
    public function validate_login(array $request):array
    {
        $customMessages = [
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
        ];
        $validator = Validator::make($request, [
            'email' => 'required|email',
            'password' => 'required',
        ], $customMessages);
        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ];
        }
        $sanitized_data = GeneralService::sanitize_data($request);
        return [
            'success' => true,
            'request' => $sanitized_data,
        ];
    }

    /**
     * @param array $data
     * @return JsonResponse|Response|false|\Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function login(array $data)
    {
        try {
            $response = Http::post('http://127.0.0.1:8000/oauth/token', [
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
                'username' => $data['email'],
                'password' => $data['password'],
                'scope' => '*',
            ]);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to login. ' . $e->getMessage()
            ], 200);
        }

        return $response->json();
    }


    /**
     * @param array $request
     * @return array
     */
    public function validate_refresh_token(array $request):array
    {
        $validator = Validator::make($request, [
            'refresh_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ];
        }

        $sanitized_data = GeneralService::sanitize_data($request);

        return [
            'success' => true,
            'request' => $sanitized_data,
        ];
    }

    /**
     * @param array $data
     * @return Response|false|\Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function refresh_token(array $data)
    {
        try {
            $response = Http::post('http://127.0.0.1:8000/oauth/token' , [
                'grant_type' => 'refresh_token',
                'refresh_token' => $data['refresh_token'],
                'client_id' => env('PASSPORT_PASSWORD_GRANT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_PASSWORD_GRANT_CLIENT_SECRET'),
            ]);

        }catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get refresh token. ' . $e->getMessage()
            ], 200);
        }
        return $response->json();
    }

}
