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
        /** @var \App\User $model */
        // Does this record belong to the current user?
        $current = $user->id === $model->id;

        return $current
            || (
                ( $user->hasRole('admin') && !$model->hasRole('admin'))
                || ($user->hasRole('dev') && !$model->hasRole('dev') && !$model->hasRole('admin'))
                || ($user->hasRole('operator') && $model->isNormalUser())
                && $this->checkPermission($user, $model, 'edit')
            );
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
        // Does this record belong to the current user?
        $current = $user->id === $model->id;

        return (
            $user->hasRole('admin')
            && (
                $user->id == 1 || $current || !$model->hasRole('admin')
                // admin cannot change role of other admin
            )
        );
    }

    /**
     * Determine if the given user can change a user a role.
     *
     * @param \TCG\Voyager\Contracts\User $user
     * @param  $model
     *
     * @return bool
     */
    public function editPassword(User $user, $model)
    {
        // Does this record belong to the current user?
        $current = $user->id === $model->id;

        return (
            $current
            || (
                $user->hasRole('admin')
                && (
                    $user->id == 1 || !$model->hasRole('admin')
                )
                // super admin can change role of other admin
                // admin cannot change role of other admin
            )
            || (
                $user->role_id && $user->role_id != 3 && empty($model->role_id)
                // other role despite `marketer` can change normal user password
            )
        );
    }

}
