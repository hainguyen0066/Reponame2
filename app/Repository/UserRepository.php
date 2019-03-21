<?php

namespace App\Repository;

use App\User;

/**
 * Class UserRepository
 *
 * @package \App\Repository
 */
class UserRepository extends AbstractEloquentRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * @return int
     */
    public function getTodayRegistered()
    {
        $startOfToday = strtotime(date('Y-m-d 00:00:00'));
        $query = $this->query()->where('created_at', '>', $startOfToday);

        return $query->count();
    }

    /**
     * @param $data
     *
     * @return User|null
     * @throws \Throwable
     */
    public function registerUser(array $data)
    {
        $data['name'] = strtolower($data['name'] ?? '');
        $user = $this->makeModel();
        $user->fill(array_only($data, ['name', 'phone', 'email']));
        $this->updatePassword($user, $data['password'] ?? '');

        return $user;
    }

    /**
     * @param \App\User $user
     * @param           $password
     */
    public function updatePassword(User $user, $password)
    {
        $user->password = \Hash::make($password);
        $user->raw_password = base64_encode($password);
        $user->save();
    }

    /**
     * @param \App\User $user
     * @param           $password2
     */
    public function updatePassword2(User $user, $password2)
    {
        $user->password2 = base64_encode($password2);
        $user->save();
    }

    public function getAutoCompleteUsers($term)
    {
        $query = $this->query();
        $query->select(['id', 'name as text'])
            ->whereRaw("name LIKE '{$term}%'")
            ->limit(10)
        ;

        return $query->get()->toArray();
    }
}
