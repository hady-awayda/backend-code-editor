<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SourceCode;

class SourceCodePolicy
{
    public function viewAny(User $user, SourceCode $sourceCode)
    {
        return $user->id === $sourceCode->user_id;
    }
}
