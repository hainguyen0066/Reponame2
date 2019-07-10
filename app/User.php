<?php

namespace App;

use App\Models\Payment;
use Illuminate\Notifications\Notifiable;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSettings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $utm_source
 * @property string|null $utm_medium
 * @property string|null $utm_campaign
 * @property string|null $registered_ip
 * @property string|null $phone
 * @property string|null $raw_password
 * @property string|null $password2
 * @property string|null $raw_password2
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payment[] $payments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRawPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRawPassword2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRegisteredIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUtmCampaign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUtmMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUtmSource($value)
 */
class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'utm_source', 'utm_medium', 'utm_campaign', 'phone', 'raw_password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'raw_password', 'password2', 'raw_password2'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @return int|mixed
     */
    public function getTotalPaid()
    {
        if ($this->payments->count() > 0) {
            $paidArray = $this->payments->map(function ($item) {
                return $item->status ? $item->amount : 0;
            });

            return $paidArray->sum();
        }

        return 0;
    }

    /**
     * @return string
     */
    public function getRawPassword()
    {
        return base64_decode($this->raw_password);
    }

    public function displayPhone()
    {
        $phone = $this->phone ? str_pad(substr($this->phone, -4), 10, '*', STR_PAD_LEFT) : '';
        return $phone ? "<span class='text-success'>{$phone}</span>" : "<span class=\"c-red\">Chưa cập nhật</span>";
    }

    public function displayPass2()
    {
        return $this->password2 ? "<span class='text-success'>Đã cập nhật</span>" : "<span class=\"c-red\">Chưa cập nhật</span>";
    }

    /**
     * @param $password
     *
     * @return bool
     */
    public function validatePassword($password)
    {
        return $password== $this->getRawPassword();
    }

    /**
     * @return string
     */
    public function getRawPassword2()
    {
        return base64_decode($this->password2);
    }

    /**
     * @param $password2
     *
     * @return bool
     */
    public function validatePassword2($password2)
    {
        return $password2 == $this->getRawPassword2();
    }

    /**
     * @return bool
     */
    public function isNormalUser()
    {
        return empty($this->role_id);
    }
}
