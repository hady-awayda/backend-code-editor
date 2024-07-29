<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SourceCode;

class SourceCodePolicy
{
    public function view(User $user, SourceCode $sourceCode)
    {
        return $user->id === $sourceCode->user_id;
    }

    public function update(User $user, SourceCode $sourceCode)
    {
        return $user->id === $sourceCode->user_id;
    }

    public function delete(User $user, SourceCode $sourceCode)
    {
        return $user->id === $sourceCode->user_id;
    }
}
