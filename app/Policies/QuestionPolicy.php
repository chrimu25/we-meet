<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Meeting;
use App\Models\Question;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Question $question): bool
    {
        return ($user->role == 'Youth' AND $question->youth_id == $user->youthDetails->id) OR 
            $user->role == 'Admin' OR 
            ($user->role == 'Coordinator' AND $question->meeting->coordinator_id == $user->coordinatorDetails->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role == 'Youth' && Meeting::active()->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Question $question): bool
    {
        return $user->role == 'Admin' OR  ($user->role == 'Coordinator' AND $question->meeting->coordinator_id == $user->coordinatorDetails->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Question $question): bool
    {
        return $user->role == 'Admin' || ($user->role == 'Coordinator' AND $question->meeting->coordinator_id == $user->coordinatorDetails->id);
    }
}
