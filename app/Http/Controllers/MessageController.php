<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;

class MessageController extends Controller
{
    public function getMessagesBetweenUsers($userId1, $userId2)
    {
        $conversation = Conversation::where(function ($query) use ($userId1, $userId2) {
            $query->where('user_id_1', $userId1)
                  ->where('user_id_2', $userId2);
        })->orWhere(function ($query) use ($userId1, $userId2) {
            $query->where('user_id_1', $userId2)
                  ->where('user_id_2', $userId1);
        })->first();

        if (!$conversation) {
            return response()->json(['message' => 'No conversation found between these users.'], 404);
        }

        $messages = $conversation->messages()->with('sender')->get();

        return response()->json($messages, 200);
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

        return response()->json(['message' => 'Message sent successfully', 'data' => $message], 201);
    }
}
