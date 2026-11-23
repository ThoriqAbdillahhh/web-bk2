<?php

namespace App\Policies;

use App\Models\Strength;
use App\Models\User;

class StrengthPolicy
{
    public function manage(User $user, Strength $strength): bool
    {
        return $user->id === $strength->user_id;
    }
}