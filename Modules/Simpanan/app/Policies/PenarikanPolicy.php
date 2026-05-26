<?php

declare(strict_types=1);

namespace Modules\Simpanan\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Simpanan\Models\Penarikan;
use Illuminate\Auth\Access\HandlesAuthorization;

class PenarikanPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Penarikan');
    }

    public function view(AuthUser $authUser, Penarikan $penarikan): bool
    {
        return $authUser->can('View:Penarikan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Penarikan');
    }

    public function update(AuthUser $authUser, Penarikan $penarikan): bool
    {
        return $authUser->can('Update:Penarikan');
    }

    public function delete(AuthUser $authUser, Penarikan $penarikan): bool
    {
        return $authUser->can('Delete:Penarikan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Penarikan');
    }

    public function restore(AuthUser $authUser, Penarikan $penarikan): bool
    {
        return $authUser->can('Restore:Penarikan');
    }

    public function forceDelete(AuthUser $authUser, Penarikan $penarikan): bool
    {
        return $authUser->can('ForceDelete:Penarikan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Penarikan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Penarikan');
    }

    public function replicate(AuthUser $authUser, Penarikan $penarikan): bool
    {
        return $authUser->can('Replicate:Penarikan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Penarikan');
    }

}