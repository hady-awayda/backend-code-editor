<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;

class ConversationController extends Controller
{
    public function getUserConversations($userId)
    {
        $conversations = Conversation::where('user_id_1', $userId)->orWhere('user_id_2', $userId)->get();

        if (!$conversations) {
            return response()->json([
                'message' => 'No conversations found'
            ], 404);
        }
        
        return response()->json([
            'data' => $conversations
        ], 200);
    }
}
