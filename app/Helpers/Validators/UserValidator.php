<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;

class UserValidator {

	public static function validate($request) {
		$validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user_id,
            'password' => 'required|string|min:8',
        ]);
		
		return $validator;
	}
}