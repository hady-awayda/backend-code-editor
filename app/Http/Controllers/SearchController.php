<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function search($username)
    {
        $users = User::where('username', 'like', '%' . $username . '%')->get();

        if (!$users) {
            return response()->json([
                'message' => 'No users found'
            ], 404);
        }
        return response()->json([
            'data' => $users
        ], 200);
    }
}