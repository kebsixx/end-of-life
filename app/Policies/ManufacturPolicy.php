<?php

namespace App\Policies;

use App\Models\Manufactur;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ManufacturPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['technician', 'user']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Manufactur $manufactur): bool
    {
        return $user->hasRole(['technician', 'user']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('technician');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Manufactur $manufactur): bool
    {
        return $user->hasRole('technician');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Manufactur $manufactur): bool
    {
        return $user->hasRole('technician');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Manufactur $manufactur): bool
    {
        return $user->hasRole('technician');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Manufactur $manufactur): bool
    {
        return $user->hasRole('technician');
    }
}
