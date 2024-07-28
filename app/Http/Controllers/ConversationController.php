<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function getConversationByUsers($user_id_1, $user_id_2)
    {
        echo "halaaa";
        $conversation = Conversation::where('user_id_1', $user_id_1)
            ->where('user_id_2', $user_id_2)
            ->orWhere('user_id_1', $user_id_2)
            ->where('user_id_2', $user_id_1)
            ->first();

        return response()->json([
            'data' => $conversation
        ], 200);
    }
}
