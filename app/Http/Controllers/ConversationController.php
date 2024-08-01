<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;

class ConversationController extends Controller
{
    public function getUserConversations($userId)
    {
        if (auth()->user()->id != $userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $conversations = Conversation::where('user_id_1', $userId)
        ->orWhere('user_id_2', $userId)
        ->with(['user1:id,name,email', 'user2:id,name,email']) // Load related users with only id, name, and email
        ->get();
        
        if (!$conversations) {
            return response()->json([
                'message' => 'No conversations found'
            ], 404);
        }

        $users = $conversations->map(function ($conversation) use ($userId) {
            if ($conversation->user_id_1 == $userId) {
                return $conversation->user2;
            } else {
                return $conversation->user1;
            }
        })->filter()->values();
        
        return response()->json([
            'data' => $users
        ], 200);
    }
}
