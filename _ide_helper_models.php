<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
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
 * @property string|null $note
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNote($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Slider
 *
 * @package \App\Models
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string|null $image
 * @property int $status
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 */
	class Slider extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Category
 *
 * @package \App\Models
 * @property int $id
 * @property int|null $parent_id
 * @property int $order
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $status
 * @property-read null $translated
 * @property-read \TCG\Voyager\Models\Category $parentId
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Post[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Category withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Category withTranslations($locales = null, $fallback = true)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category orderByPublishDate()
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Gallery
 *
 * @package \App\Models
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $images
 * @property int|null $order
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gallery whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Gallery extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Server
 *
 * @package \App\Models
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $link
 * @property string $status
 * @property string|null $display_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereDisplayText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereGameServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $game_server_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 */
	class Server extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Post
 *
 * @package \App\Models
 * @property int $id
 * @property int $author_id
 * @property int|null $category_id
 * @property string $title
 * @property string|null $seo_title
 * @property string|null $excerpt
 * @property string $body
 * @property string|null $image
 * @property string $slug
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property int $status
 * @property int $featured
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $publish_date
 * @property-read \TCG\Voyager\Models\User $authorId
 * @property-read \TCG\Voyager\Models\Category|null $category
 * @property-read null $translated
 * @property-read \Illuminate\Database\Eloquent\Collection|\TCG\Voyager\Models\Translation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Post withTranslation($locale = null, $fallback = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\TCG\Voyager\Models\Post withTranslations($locales = null, $fallback = true)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post categorySlug($categorySlug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post orderByPublishDate()
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Banner
 *
 * @package \App\Models
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string|null $image
 * @property int $status
 * @property string|null $start_date
 * @property string|null $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Banner whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 */
	class Banner extends \Eloquent {}
}

namespace App\Models{
/**
 * Class Payment
 *
 * @package \App\Models
 * @property int $id
 * @property string|null $card_pin
 * @property string|null $card_serial
 * @property string|null $card_type
 * @property string|null $transaction_id
 * @property string|null $utm_source
 * @property string|null $utm_medium
 * @property string|null $utm_campaign
 * @property string|null $pay_method
 * @property string|null $pay_from
 * @property string|null $expired_date
 * @property int|null $user_id
 * @property string|null $username
 * @property int|null $server_id
 * @property int|null $payment_type
 * @property int|null $card_amount
 * @property int|null $gamecoin
 * @property int|null $gamecoin_promotion
 * @property int $status
 * @property int $finished
 * @property int $gold_added
 * @property int $gateway_status
 * @property string|null $gateway_response
 * @property string|null $gateway_amount
 * @property string|null $ip
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $note
 * @property int|null $creator_id
 * @property int|null $amount
 * @property-read \App\User|null $creator
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCardAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCardPin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCardSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereFinished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGamecoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGamecoinPromotion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGatewayAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGatewayResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGatewayStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereGoldAdded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePayFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePayMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUtmCampaign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUtmMedium($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUtmSource($value)
 * @mixin \Eloquent
 * @property int|null $status_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereStatusCode($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * Class UserCharacter
 *
 * @package \App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 * @mixin \Eloquent
 */
	class UserCharacter extends \Eloquent {}
}

namespace App\Models{
/**
 * Class GiftCode
 *
 * @package \App\Models
 * @property int $id
 * @property string $code
 * @property int|null $is_used
 * @property string|null $expired_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode notExpires()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode notOwned()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseEloquentModel orderByPublishDate()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode unused()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereExpiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereIsUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\GiftCode whereUserId($value)
 * @mixin \Eloquent
 */
	class GiftCode extends \Eloquent {}
}

