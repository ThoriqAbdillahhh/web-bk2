<?php

namespace App\Policies;

use App\Models\Journal;
use App\Models\User;

class JournalPolicy
{
    public function manage(User $user, Journal $journal): bool
    {
        return $user->id === $journal->user_id;
    }

    public function review(User $user, Journal $journal): bool
    {
    return $user->hasRole('guru') && $journal->is_shared;
    }

}