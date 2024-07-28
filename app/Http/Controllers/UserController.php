<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\UserService;

class UserController extends Controller
{
    public function getAllUsers() {
        $users = User::all();
        
        return response()->json([
            'data' => $users
        ], 200);
    }
    
    public function getUserById($user_id) {
        $user = User::find($user_id);

        return response()->json([
            'data' => $user
        ], 200);
    }

    public function createUser(Request $request) {
        $response = UserService::createUser($request);

        if ($response == "success") {
            return response()->json([
                'message' => 'Created Successfully'
            ], 201);
        } else {
            return response()->json([
                "errors" => $response
            ], 422);
        }
    }

    public function updateUser(Request $request, $user_id) {
        $response = UserService::updateUser($request, $user_id);
        
        if ($response == "success") {
            return response()->json([
                'message' => 'Updated Successfully'
            ], 200);
        } else {
            return response()->json([
                "errors" => $response
            ], 422);
        }
    }

    public function deleteUser($id)
    {
        $response = UserService::deleteUser($id);

        if ($response === "success") {
            return response()->json([
                "message" => 'Deleted Successfully'
            ]);
        } else {
            return response()->json([
                "message" => $response
            ], 404);
        }
    }
}
