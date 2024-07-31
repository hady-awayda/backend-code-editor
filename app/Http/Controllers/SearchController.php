<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SearchController extends Controller
{
    public function search($username)
    {
        $users = User::where('name', 'like', '%' . $username . '%')
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