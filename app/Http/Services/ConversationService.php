<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ConversationService
{
	public static function createConversation($request)
	{
		if ($request->user_id_1 === $request->user_id_2) {
			return "Conversation requires 2 distinct users";
		}

		$validator = Validator::make($request->all(), [
			"user_id_1" => 'required|exists:users,id',
			"user_id_2" => 'required|exists:users,id',
		]);

		if ($validator->fails()) {
			return $validator->errors();
		}

		$conversation = new Conversation();
		
		$conversation->name = $request->name;
		$conversation->user_id_1 = $request->user_id_1;
		$conversation->user_id_2 = $request->user_id_2;
		$conversation->message = $request->message;

		$conversation->save();

		return $conversation;
	}

}
