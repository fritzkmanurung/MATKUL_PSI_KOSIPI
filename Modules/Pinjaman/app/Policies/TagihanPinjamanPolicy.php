<?php

declare(strict_types=1);

namespace Modules\Pinjaman\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Pinjaman\Models\TagihanPinjaman;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagihanPinjamanPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TagihanPinjaman');
    }

    public function view(AuthUser $authUser, TagihanPinjaman $tagihanPinjaman): bool
    {
        return $authUser->can('View:TagihanPinjaman');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TagihanPinjaman');
    }

    public function update(AuthUser $authUser, TagihanPinjaman $tagihanPinjaman): bool
    {
        return $authUser->can('Update:TagihanPinjaman');
    }

    public function delete(AuthUser $authUser, TagihanPinjaman $tagihanPinjaman): bool
    {
        return $authUser->can('Delete:TagihanPinjaman');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TagihanPinjaman');
    }

    public function restore(AuthUser $authUser, TagihanPinjaman $tagihanPinjaman): bool
    {
        return $authUser->can('Restore:TagihanPinjaman');
    }

    public function forceDelete(AuthUser $authUser, TagihanPinjaman $tagihanPinjaman): bool
    {
        return $authUser->can('ForceDelete:TagihanPinjaman');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TagihanPinjaman');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TagihanPinjaman');
    }

    public function replicate(AuthUser $authUser, TagihanPinjaman $tagihanPinjaman): bool
    {
        return $authUser->can('Replicate:TagihanPinjaman');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TagihanPinjaman');
    }

}