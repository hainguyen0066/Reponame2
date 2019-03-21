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
        return $this->checkPermission($user, $model, 'read');
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
        return $user->hasPermission('edit_roles');
    }
}
