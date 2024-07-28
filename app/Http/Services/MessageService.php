<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;

class MessageService
{
	public static function getConversation($userId1, $userId2)
	{
		$conversation = Conversation::where(function ($query) use ($userId1, $userId2) {
            $query->where('user_id_1', $userId1)
                  ->where('user_id_2', $userId2);
        })->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('user_id_1', $userId2)
                  ->where('user_id_2', $userId1);
        })->first();

		if (!$conversation) {
            return "Conversation not found";
        }

        $messages = $conversation->messages()->get();

		return $messages;
	}
	
	public static function addMessage($request)
	{
        $validator = Validator::make($request->all(), [
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id|different:sender_id',
            'message' => 'required|string'
        ]);

		if ($validator->fails()) {
			return $validator->errors();
		}
		
		$message = new Message();

		$validated_data = $validator->validated();

		$message->fill($validated_data);
        
        $message->save();

		return "success"; 
	}
}
