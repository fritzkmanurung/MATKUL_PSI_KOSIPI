<?php

declare(strict_types=1);

namespace Modules\Pinjaman\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Pinjaman\Models\Pinjaman;
use Illuminate\Auth\Access\HandlesAuthorization;

class PinjamanPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Pinjaman');
    }

    public function view(AuthUser $authUser, Pinjaman $pinjaman): bool
    {
        return $authUser->can('View:Pinjaman');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Pinjaman');
    }

    public function update(AuthUser $authUser, Pinjaman $pinjaman): bool
    {
        return $authUser->can('Update:Pinjaman');
    }

    public function delete(AuthUser $authUser, Pinjaman $pinjaman): bool
    {
        return $authUser->can('Delete:Pinjaman');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Pinjaman');
    }

    public function restore(AuthUser $authUser, Pinjaman $pinjaman): bool
    {
        return $authUser->can('Restore:Pinjaman');
    }

    public function forceDelete(AuthUser $authUser, Pinjaman $pinjaman): bool
    {
        return $authUser->can('ForceDelete:Pinjaman');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Pinjaman');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Pinjaman');
    }

    public function replicate(AuthUser $authUser, Pinjaman $pinjaman): bool
    {
        return $authUser->can('Replicate:Pinjaman');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Pinjaman');
    }

}