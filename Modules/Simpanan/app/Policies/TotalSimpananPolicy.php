<?php

declare(strict_types=1);

namespace Modules\Simpanan\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Simpanan\Models\TotalSimpanan;
use Illuminate\Auth\Access\HandlesAuthorization;

class TotalSimpananPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TotalSimpanan');
    }

    public function view(AuthUser $authUser, TotalSimpanan $totalSimpanan): bool
    {
        return $authUser->can('View:TotalSimpanan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TotalSimpanan');
    }

    public function update(AuthUser $authUser, TotalSimpanan $totalSimpanan): bool
    {
        return $authUser->can('Update:TotalSimpanan');
    }

    public function delete(AuthUser $authUser, TotalSimpanan $totalSimpanan): bool
    {
        return $authUser->can('Delete:TotalSimpanan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TotalSimpanan');
    }

    public function restore(AuthUser $authUser, TotalSimpanan $totalSimpanan): bool
    {
        return $authUser->can('Restore:TotalSimpanan');
    }

    public function forceDelete(AuthUser $authUser, TotalSimpanan $totalSimpanan): bool
    {
        return $authUser->can('ForceDelete:TotalSimpanan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TotalSimpanan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TotalSimpanan');
    }

    public function replicate(AuthUser $authUser, TotalSimpanan $totalSimpanan): bool
    {
        return $authUser->can('Replicate:TotalSimpanan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TotalSimpanan');
    }

}