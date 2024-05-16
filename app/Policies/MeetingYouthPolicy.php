<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MeetingYouth;

class MeetingYouthPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role != 'Youth';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MeetingYouth $attendance): bool
    {
        return $user->role != 'Youth';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MeetingYouth $attendance): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MeetingYouth $attendance): bool
    {
        return false;
    }
}
