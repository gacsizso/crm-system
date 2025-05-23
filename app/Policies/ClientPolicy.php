<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;

class ClientPolicy
{
    /**
     * Determine if the user can update the client.
     */
    public function update(User $user, Client $client)
    {
        return $user->hasRole(['admin', 'manager']);
    }

    /**
     * Determine if the user can delete the client.
     */
    public function delete(User $user, Client $client)
    {
        return $user->hasRole(['admin', 'manager']);
    }

    /**
     * Determine if the user can assign contacts to the client.
     */
    public function assignContact(User $user, Client $client)
    {
        return $user->hasRole(['admin', 'manager']);
    }
} 