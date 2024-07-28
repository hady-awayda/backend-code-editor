<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserService
{
	public static function createUser($request){
		$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

		return "success";
	}
	
	public static function updateUser($request, $user_id)
	{
		$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user_id,
            'password' => 'required|string|min:8',
        ]);
		
        if ($validator->fails()) {
            return $validator->errors();
        }
        
		$user = User::find($user_id);

		if (!$user) {
			return "User not found";
		}
		
        $user->name = $request->name;
        $user->email = $request->email;

		if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

		return "success";
	}

	public static function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return "User not found";
        }
        
        $user->delete();

        return "success";
    }
}