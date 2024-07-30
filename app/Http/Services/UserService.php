<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\Validators\UserValidator;

class UserService
{
    // expand to updateUsername, updateEmail, updatePassword
	public static function updateUser($request, $user_id)
	{
		$user = User::find($user_id);

        if (!$user) {
            return "User not found";
        }

        $validator = UserValidator::validate($request);
		
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

        $validator = UserValidator::validate($request);

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