<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Youth;
use Illuminate\Auth\Access\Response;

class YouthPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role == 'Admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Youth $youth): bool
    {
        return $user->role == 'Admin';
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
    public function update(User $user, Youth $youth): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Youth $youth): bool
    {
        return false;
    }
}
