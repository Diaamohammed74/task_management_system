<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return in_array($user->type,['super_admin','admin','Supervisor','employee']);
    }
    public function viewAny(User $user)
    {
        //
    }
    public function create(User $user)
    {
        return in_array($user->type,['super_admin','Supervisor']);
    }
    public function edit(User $user)
    {
        return in_array($user->type,['super_admin','Supervisor','admin','employee']);
    }
    public function delete(User $user)
    {
        //
    }
    public function restore(User $user)
    {
        //
    }
    public function forceDelete(User $user)
    {
        //
    }
}
