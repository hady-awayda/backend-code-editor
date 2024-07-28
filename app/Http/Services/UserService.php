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
	
    // expand to updateUsername, updateEmail, updatePassword
	public static function updateUser($request, $user_id)
	{
		$user = User::find($user_id);

        if (!$user) {
            return "User not found";
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user_id,
            'password' => 'required|string|min:8',
        ]);
		
        if ($validator->fails()) {
            return $validator->errors();
        }

        if (!Hash::check($request->password, $user->password)) {
            return ['error' => 'Wrong password'];
        }
		
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

		return "success";
	}

	public static function deleteUser($request, $user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return "User not found";
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user_id,
            'password' => 'required|string|min:8',
        ]);
		
        if ($validator->fails()) {
            return $validator->errors();
        }

        if (!Hash::check($request->password, $user->password)) {
            return ['error' => 'Wrong password'];
        }
        
        $user->delete();

        return "success";
    }
}