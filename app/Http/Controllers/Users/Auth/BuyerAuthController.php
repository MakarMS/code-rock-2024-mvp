<?php

namespace App\Http\Controllers\Users\Auth;

use App\Enums\AuthCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\BuyerRegistrationRequest;
use App\Http\Requests\Users\UserLoginRequest;
use App\Models\Users\BuyerUser;
use App\Services\Users\UserAuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BuyerAuthController extends Controller
{
    public function register(BuyerRegistrationRequest $request): JsonResponse
    {
        $user = (new BuyerUser())->fill([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'patronymic' => $request->input('patronymic'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]
        );

        $userAuthService = new UserAuthService();

        try {
            $token = $userAuthService->register($user);
        } catch (AuthenticationException) {
            return new JsonResponse(['code' => AuthCodes::NOT_UNIQUE_EMAIL], 401);
        }

        return $userAuthService->respondWithToken($token);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $user = (new BuyerUser())->fill([
                'email' => $request->input('email'),
                'password' => $request->input('password')]
        );

        $userAccountService = new UserAuthService();

        try {
            $token = $userAccountService->login($user, 'buyer', $request->input('remember_me'));
        } catch (AuthenticationException) {
            return new JsonResponse(['code' => AuthCodes::WRONG_LOGIN], 401);
        }

        return $userAccountService->respondWithToken($token);
    }

    public function refresh(): JsonResponse
    {
        return (new UserAuthService())->respondWithToken(Auth::refresh());
    }

    public function valid(): JsonResponse
    {
        return new JsonResponse(['status' => Auth::guard('buyer')->check()]);
    }
}
