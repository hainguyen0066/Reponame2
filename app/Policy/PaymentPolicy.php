<?php

namespace App\Policy;

use TCG\Voyager\Contracts\User;
use TCG\Voyager\Policies\BasePolicy;

/**
 * Class PaymentPolicy
 *
 * @package \App\Policy
 */
class PaymentPolicy extends BasePolicy
{
    public function read(User $user, $model)
    {
        return false;
    }
}
