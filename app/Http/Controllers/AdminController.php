<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\ImportService;

class AdminController extends Controller
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

    // prototype
    public function importUsers(Request $request) {
        $file = $request->file('file');

        if (!$file) {
            return response()->json([
                'message' => 'No file found'
            ], 404);
        }

        $lines = file($file->getRealPath());

        if (!$lines) {
            return response()->json([
                'message' => 'No lines found'
            ], 404);
        }

        for ($i = 0; $i < count($lines); $i++) {
            ImportService::insertUser($lines[$i]);
        }
        
        return response()->json([
            'message' => 'Users imported successfully'
        ], 200);
    }
}
