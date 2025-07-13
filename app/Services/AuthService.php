<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthService
{
    public function login(array $data) :array{
        $credentials = $data;
        if (Auth::attempt($credentials)) {
            $token = Auth::user()->createToken('auth_token')->plainTextToken;
            $data = [
                'user' => Auth::user(),
                'token' => $token
            ];
            return $data;
        }
        throw new \Exception('Invalid credentials');
    }
}
