<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list customers');
    }

    public function view(User $user, Customer $model): bool
    {
        return $user->hasPermissionTo('view customers');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create customers');
    }

    public function update(User $user, Customer $model): bool
    {
        return $user->hasPermissionTo('update customers');
    }

    public function delete(User $user, Customer $model): bool
    {
        return $user->hasPermissionTo('delete customers');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete customers');
    }

    public function restore(User $user, Customer $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Customer $model): bool
    {
        return false;
    }
}
