<?php

namespace App\Repository;

use App\Models\GiftCode;
use App\User;

/**
 * Class GiftCodeRepository
 *
 * @package \App\Repository
 */
class GiftCodeRepository extends AbstractEloquentRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return GiftCode::class;
    }

    /**
     * @param \App\User $user
     *
     * @return GiftCode|null
     */
    public function getCodeOwnedByUser(User $user)
    {
        $query = $this->query();
        $query->where('user_id', $user->id);

        return $query->first();
    }

    /**
     * @return GiftCode|null
     */
    public function getWelcomeCode()
    {
        $query = $this->query();
        $query->unused()
            ->notExpires()
            ->notOwned()
        ;

        return $query->first();
    }

    public function issueCodeForUser(User $user, GiftCode $giftCode)
    {
        $giftCode->user_id = $user->id;
        $giftCode->save();
    }
}
