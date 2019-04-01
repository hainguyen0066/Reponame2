<?php

namespace App\Policy;

use TCG\Voyager\Contracts\User;

/**
 * Class UserPolicy
 *
 * @package \App\Policy
 */
class UserPolicy extends \TCG\Voyager\Policies\UserPolicy
{
    public function read(User $user, $model)
    {
        return false;
    }

    /**
     * Determine if the given model can be edited by the user.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param  $model
     *
     * @return bool
     */
    public function edit(User $user, $model)
    {
        // Does this record belong to the current user?
        $current = $user->id === $model->id;

        return $current || (!$model->hasRole('admin') && $this->checkPermission($user, $model, 'edit'));
    }

    /**
     * Determine if the given user can change a user a role.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param  $model
     *
     * @return bool
     */
    public function editRoles(User $user, $model)
    {
        return !$model->hasRole('admin') && $user->hasPermission('edit_roles');
    }
}
