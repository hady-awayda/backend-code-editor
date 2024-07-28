<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use App\Http\Services\MessageService;

class MessageController extends Controller
{
    public function getMessagesBetweenUsers($userId1, $userId2)
    {
        $messages = MessageService::getConversation($userId1, $userId2);

        if ($messages === "Conversation not found") {
            return response()->json([
                'message' => $messages
            ], 404);
        }

        return response()->json([
            'data' => $messages
        ], 200);
    }

    public function addMessageToConversation(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id|different:sender_id',
            'message' => 'required|string'
        ]);

        $senderId = $request->input('sender_id');
        $receiverId = $request->input('receiver_id');
        $messageText = $request->input('message');

        $conversation = Conversation::firstOrCreate([
            'user_id_1' => min($senderId, $receiverId),
            'user_id_2' => max($senderId, $receiverId),
        ]);

        $message = new Message();

        $message->conversation_id = $conversation->id;
        $message->sender_id = $senderId;
        $message->message = $messageText;
        
        $message->save();

        return response()->json(['message' => 'Message sent successfully'], 201);
    }
}
