<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkspacePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Workspace $workspace)
    {
        return $user->id == $workspace->owner_user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Workspace $workspace)
    {
        return $user->id == $workspace->owner_user_id;
    }

    public function delete(User $user, Workspace $workspace)
    {
        return $user->id == $workspace->owner_user_id;
    }

    public function restore(User $user, Workspace $workspace)
    {
        return $user->id == $workspace->owner_user_id;
    }

    public function forceDelete(User $user, Workspace $workspace)
    {
        return $user->id == $workspace->owner_user_id;
    }
}
