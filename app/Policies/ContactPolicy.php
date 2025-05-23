<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contact;

class ContactPolicy
{
    /**
     * Determine if the user can update the contact.
     */
    public function update(User $user, Contact $contact)
    {
        // If there is a user_id field, allow self-edit, else only admin/manager
        if (isset($contact->user_id)) {
            return $user->hasRole(['admin', 'manager']) || $user->id === $contact->user_id;
        }
        return $user->hasRole(['admin', 'manager']);
    }

    /**
     * Determine if the user can delete the contact.
     */
    public function delete(User $user, Contact $contact)
    {
        return $user->hasRole(['admin', 'manager']);
    }
} 