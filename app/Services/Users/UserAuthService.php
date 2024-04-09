<?php

namespace App\Services\Users;

use App\Models\Users\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserAuthService
{
    /**
     * @throws AuthenticationException
     */
    public function register(User $user): string
    {
        if ($user->userExists($user->email)) {
            throw new AuthenticationException();
        }

        $user->save();

        return Auth::login($user);
    }

    public function login(User $userModel, string $guard, bool $rememberMe): string
    {
        $credentials = [
            'email' => $userModel->email,
            'password' => $userModel->password,
        ];

        if ($token = Auth::guard($guard)->attempt($credentials, $rememberMe)) {
            return $token;
        }

        throw new AuthenticationException();
    }

    public function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'jwt_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL()
        ]);
    }
}
