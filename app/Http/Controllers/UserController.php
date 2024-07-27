<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getAllUsers() {
        $users = User::all();
    }
    
    // public function getAllUsers()
    // {
    //     $users = User::all();
    //     return $users;
    // }

    // public function getUserById($id)
    // {
    //     $user = User::find($id);
    //     return $user;
    // }

    // public function createUser(Request $request)
    // {
    //     $user = new User();
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->password = Hash::make($request->password);
    //     $user->save();
    //     return $user;
    // }

    // public function updateUser(Request $request, $id)
    // {
    //     $user = User::find($id);
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->save();
    //     return $user;
    // }

    // public function deleteUser($id)
    // {
    //     $user = User::find($id);
    //     $user->delete();
    //     return $user;
    // }
}
