<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;

class UserController extends Controller
{
    public function getAllUsers() {
        $users = User::all();

        if (!$users) {
            return response()->json([
                'message' => 'No users found'
            ], 404);
        }
        
        return response()->json([
            'data' => $users
        ], 200);
    }
    
    public function getUserById($user_id) {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        } 

        return response()->json([
            'data' => $user
        ], 200);
    }

    public function updateUser(Request $request, $user_id) {
        $response = UserService::updateUser($request, $user_id);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Updated Successfully'
            ], 204);
        }
        
        return response()->json([
            "errors" => $response
        ], 422);
    }

    public function deleteUser(Request $request, $id) {
        $response = UserService::deleteUser($request, $id);

        if ($response === "success") {
            return response()->json([
                "message" => 'Deleted Successfully'
            ], 204);
        }
        
        return response()->json([
            "message" => $response
        ], 404);
    }
}
