<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Nickname;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (! $token = auth()->attempt($data)) {
            return response()->json(['error' => 'Неверный логин или пароль.'], 401);
        }
        return $this->createNewToken($token);
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create(array_merge(
            $data,
            ['password' => bcrypt($request->password)]
        ));
        $token = auth()->login($user);
        return $this->createNewToken($token);
    }

    public function getUser() {
        return response()->json(auth()->user());
    }

    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    protected function createNewToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
