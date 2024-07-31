<?php

namespace App\Helpers\Validators;

use Illuminate\Support\Facades\Validator;

class UserValidator {

	public static function validate($record) {
		$validator = Validator::make($record, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,',
            'password' => 'required|string|min:8',
        ]);
		
		return $validator;
	}
}