<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AuthRepository;
use App\Services\AuthService;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(
        protected AuthRepository $authRepository,
        protected AuthService $authService
    ){}   

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 400);        
        }

        $data = $validator->validated();
        try{
            $user = $this->authRepository->register($data);
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
            ], 201);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()], 400);        
        }

        $data = $validator->validated();
        try{
            $auth = $this->authService->login($data);
            return response()->json([
                'message' => 'User logged in successfully',
                'auth' => $auth,
            ], 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }            
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'User logged out successfully'
        ], 200);
    }
}
