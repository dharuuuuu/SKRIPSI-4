<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Item;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list items');
    }

    public function view(User $user, Item $model): bool
    {
        return $user->hasPermissionTo('view items');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create items');
    }

    public function update(User $user, Item $model): bool
    {
        return $user->hasPermissionTo('update items');
    }

    public function delete(User $user, Item $model): bool
    {
        return $user->hasPermissionTo('delete items');
    }

    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete items');
    }

    public function restore(User $user, Item $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, Item $model): bool
    {
        return false;
    }
}
