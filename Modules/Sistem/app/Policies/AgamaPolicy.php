<?php

declare(strict_types=1);

namespace Modules\Sistem\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use Modules\Sistem\Models\Agama;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgamaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Agama');
    }

    public function view(AuthUser $authUser, Agama $agama): bool
    {
        return $authUser->can('View:Agama');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Agama');
    }

    public function update(AuthUser $authUser, Agama $agama): bool
    {
        return $authUser->can('Update:Agama');
    }

    public function delete(AuthUser $authUser, Agama $agama): bool
    {
        return $authUser->can('Delete:Agama');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Agama');
    }

    public function restore(AuthUser $authUser, Agama $agama): bool
    {
        return $authUser->can('Restore:Agama');
    }

    public function forceDelete(AuthUser $authUser, Agama $agama): bool
    {
        return $authUser->can('ForceDelete:Agama');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Agama');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Agama');
    }

    public function replicate(AuthUser $authUser, Agama $agama): bool
    {
        return $authUser->can('Replicate:Agama');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Agama');
    }

}