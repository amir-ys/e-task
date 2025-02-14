<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Utilities\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the login process for a user.
     *
     * This method authenticates the user using the provided email and password.
     * If the user does not exist or the password is incorrect, an unauthorized response is returned.
     * Upon successful authentication, a new API token is generated for the user and returned with the user data.
     *
     * @param LoginRequest $request The validated login request containing the user's email and password.
     * @return JsonResponse  A JSON response containing either the success message with the token and user data or an unauthorized error message.
     *
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::query()->where('email', $data['email'])->first();
        if (!$user) {
            return ApiResponse::unauthorized(
                'User account not found. Please sign up to continue.'
            );
        }

        if (!Hash::check($data['password'], $user->password)) {
            return ApiResponse::unauthorized(
                'Incorrect email or password. Please try again.'
            );
        }

        $token = $user->createToken('ehna');
        return ApiResponse::success(
            data: [
                'token' => $token->plainTextToken,
                'user' => UserResource::make($user),
            ],
            message: 'User logged in successfully'
        );
    }
}
