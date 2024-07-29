<?php

namespace App\Policies;

use App\Models\SourceCode;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SourceCodePolicy
{
    // use HandlesAuthorization;

    // public function viewAny(User $user)
    // {
    //     return true; // Allow all authenticated users to view their source codes
    // }

    // public function view(User $user, SourceCode $sourceCode)
    // {
    //     return $user->id === $sourceCode->user_id;
    // }

    // public function create(User $user)
    // {
    //     return true; // Allow all authenticated users to create source codes
    // }

    // public function update(User $user, SourceCode $sourceCode)
    // {
    //     return $user->id === $sourceCode->user_id;
    // }

    // public function delete(User $user, SourceCode $sourceCode)
    // {
    //     return $user->id === $sourceCode->user_id;
    // }
}