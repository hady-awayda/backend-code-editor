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
        // if (auth()->user()->id != $userId1 || auth()->user()->id != $userId2) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }
        
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

        $data = $validator->validated();

        $senderId = $data['sender_id'];
        $receiverId = $data['receiver_id'];
        $messageContent = $data['message'];

        $conversation = Conversation::where(function($query) use ($senderId, $receiverId) {
            $query->where('user_id_1', $senderId)
                  ->where('user_id_2', $receiverId);
        })->orWhere(function($query) use ($senderId, $receiverId) {
            $query->where('user_id_1', $receiverId)
                  ->where('user_id_2', $senderId);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_id_1' => $senderId,
                'user_id_2' => $receiverId,
            ]);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $senderId,
            'message' => $messageContent,
        ]);

        return "success";
	}
}
