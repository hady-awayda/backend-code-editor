<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function search($username)
    {
        $validator = Validator::make(['username' => $username], [
            'username' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $name = $validator->validated()['username'];
        
        $users = User::where('name', 'like', '%' . $name . '%')
        ->select('id', 'name')
        ->get();

        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'No users found'
            ], 404);
        }
        return response()->json([
            'data' => $users
        ], 200);
    }
}