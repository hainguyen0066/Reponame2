<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseEloquentModel
 *
 * @package \App\Models
 */
abstract class BaseEloquentModel extends Model
{
    use BaseEloquentModelTrait;
}
