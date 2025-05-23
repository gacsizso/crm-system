<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    public function update(User $user, Group $group): bool
    {
        return $user->hasRole(['admin', 'manager']) || $user->id === $group->created_by;
    }

    public function delete(User $user, Group $group): bool
    {
        return $user->hasRole(['admin', 'manager']) || $user->id === $group->created_by;
    }
} 