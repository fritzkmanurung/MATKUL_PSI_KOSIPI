<?php

declare(strict_types=1);

namespace Modules\Sistem\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Sistem\Models\Bunga;
use Illuminate\Auth\Access\HandlesAuthorization;

class BungaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Bunga');
    }

    public function view(AuthUser $authUser, Bunga $bunga): bool
    {
        return $authUser->can('View:Bunga');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Bunga');
    }

    public function update(AuthUser $authUser, Bunga $bunga): bool
    {
        return $authUser->can('Update:Bunga');
    }

    public function delete(AuthUser $authUser, Bunga $bunga): bool
    {
        return $authUser->can('Delete:Bunga');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Bunga');
    }

    public function restore(AuthUser $authUser, Bunga $bunga): bool
    {
        return $authUser->can('Restore:Bunga');
    }

    public function forceDelete(AuthUser $authUser, Bunga $bunga): bool
    {
        return $authUser->can('ForceDelete:Bunga');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Bunga');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Bunga');
    }

    public function replicate(AuthUser $authUser, Bunga $bunga): bool
    {
        return $authUser->can('Replicate:Bunga');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Bunga');
    }

}