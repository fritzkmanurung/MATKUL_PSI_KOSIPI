<?php

declare(strict_types=1);

namespace Modules\Simpanan\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Simpanan\Models\Simpanan;
use Illuminate\Auth\Access\HandlesAuthorization;

class SimpananPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Simpanan');
    }

    public function view(AuthUser $authUser, Simpanan $simpanan): bool
    {
        return $authUser->can('View:Simpanan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Simpanan');
    }

    public function update(AuthUser $authUser, Simpanan $simpanan): bool
    {
        return $authUser->can('Update:Simpanan');
    }

    public function delete(AuthUser $authUser, Simpanan $simpanan): bool
    {
        return $authUser->can('Delete:Simpanan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Simpanan');
    }

    public function restore(AuthUser $authUser, Simpanan $simpanan): bool
    {
        return $authUser->can('Restore:Simpanan');
    }

    public function forceDelete(AuthUser $authUser, Simpanan $simpanan): bool
    {
        return $authUser->can('ForceDelete:Simpanan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Simpanan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Simpanan');
    }

    public function replicate(AuthUser $authUser, Simpanan $simpanan): bool
    {
        return $authUser->can('Replicate:Simpanan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Simpanan');
    }

}