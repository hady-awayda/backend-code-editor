<?php

namespace App\Http\Services;

use App\Models\User;
use App\Helpers\Validators\UserValidator;

class ImportService
{
	public static function insertUser($record) {
		$validator = UserValidator::validate($record);
		
        if ($validator->fails()) {
            return $validator->errors();
        }

		$data = $validator->validated();

        User::insert($data);
	}
}