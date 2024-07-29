<?php

namespace App\Http\Controllers;

use App\Handlers\User\AuthHandler;
use App\Models\User;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->only('name', 'email', 'password');

        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                "message" => $validator->errors()
            ], 422);
        }

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        if ($user) {
            $authHandler = new AuthHandler;
            $token = $authHandler->GenerateToken($user);

            return response()->json([
                "data" => [
                    "token" => $token,
                ]
            ], 201);
        }
    }

    public function login(Request $request)
    {
        $input = $request->only('email', 'password');

        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                "message" => $validator->errors()
            ], 422);
        }

        $remember = $request->remember;

        if(Auth::attempt($input, $remember)){
            $user = Auth::user();

            $authHandler = new AuthHandler;
            $token = $authHandler->GenerateToken($user);

            return response()->json([
                "data" => [
                    "token" => $token,
                ]
            ], 201);
        }
        else{
            return response()->json([
                'message' => "Invalid login credentials"
            ], 401);
        }
    }
}