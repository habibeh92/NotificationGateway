<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;



    /**
     * UserController constructor
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }



    /**
     * register the user
     *
     * @param UserRegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request)
    {
        $request->merge([
            "password" => Hash::make($request->password),
        ]);

        $user = $this->userRepository->register($request->toArray());

        if ($user->exists) {
            Auth::login($user);
        }

        return ApiResponse::success([
            'message' => 'User Created Successfully',
            'token'   => $user->createToken("API TOKEN")->plainTextToken,
        ]);
    }



    /**
     * login the registered user
     *
     * @param UserLoginRequest $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->toArray())) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        return ApiResponse::success([
            'token' => $this->userRepository->createToken()->plainTextToken,
        ]);
    }



    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->userRepository->logout();

        return ApiResponse::success([
            "message" => "successfully Logged out.",
        ]);
    }
}
