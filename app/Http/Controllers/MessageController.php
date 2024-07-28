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
        $response = MessageService::addMessage($request);

        if ($response === "success") {
            return response()->json([
                'message' => 'Message sent successfully'
            ], 201);
        }
        
        return response()->json([
            "errors" => $response
        ], 422);
    }
}
