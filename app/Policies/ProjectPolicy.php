<?php

namespace App\Policies;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;
    public function index(User $user)
    {
        return in_array($user->type,['super_admin','admin','Supervisor']);
    }

    public function create(User $user)
    {
        return in_array($user->type,['super_admin','admin']);
    }
    public function edit(User $user)
    {
        return in_array($user->type,['super_admin','admin','Supervisor']);
    }
    public function update(User $user)
    {
        return in_array($user->type,['super_admin','admin','Supervisor']);

    }
    public function destroy(User $user)
    {
        return in_array($user->type,['super_admin','admin','Supervisor']);
    }
    public function archive(User $user)
    {
        return in_array($user->type,['super_admin','admin','Supervisor']);
    }
    public function restore(User $user)
    {
        return in_array($user->type,['super_admin','admin']);
    }

}
