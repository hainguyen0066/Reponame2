<?php

namespace App;

use T2G\Common\Models\AbstractUser;
use T2G\Common\Models\Payment;

/**
 * App\User
 *
 * @property int $id
 * @property int|null $role_id
 * @property string $name
 * @property string $email
 * @property string|null $avatar
 * @property string|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property array|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $locale
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \TCG\Voyager\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $utm_source
 * @property string|null $utm_medium
 * @property string|null $utm_campaign
 * @property string|null $registered_ip
 * @property string|null $phone
 * @property string|null $raw_password
 * @property string|null $password2
 * @property string|null $raw_password2
 * @property-read \Illuminate\Database\Eloquent\Collection|Payment[] $payments
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRawPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRawPassword2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRegisteredIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUtmCampaign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUtmMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUtmSource($value)
 * @property string|null $note
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNote($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\T2G\Common\Models\Revision[] $advancedRevisionHistory
 * @property-read \Illuminate\Database\Eloquent\Collection|\T2G\Common\Models\Revision[] $revisionHistory
 */
class User extends AbstractUser
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
