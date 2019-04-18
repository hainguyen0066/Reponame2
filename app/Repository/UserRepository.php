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
        $startOfToday = date('Y-m-d 00:00:00');
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

    public function getAutoCompleteUsers($term, $limit = 10)
    {
        $query = $this->query();
        $query->select(['id', 'name as text'])
            ->whereRaw("name LIKE '{$term}%'")
            ->orderBy('name', 'ASC')
            ->limit($limit)
        ;

        return $query->get()->toArray();
    }

    public function getUserRegisteredReport($fromDate, $toDate)
    {
        $fromDate = strtotime($fromDate);
        $toDate = strtotime($toDate);
        $data = \DB::table('users')->selectRaw("DATE_FORMAT(created_at, '%d-%m') as `date`, CONCAT(utm_campaign, '.', utm_medium, '.', utm_source) as `cid`, DATE_FORMAT(created_at, '%m-%d') as ordered_date, COUNT(id) as `total`")
            ->whereRaw("UNIX_TIMESTAMP(CONVERT_TZ(created_at, '+07:00', '+00:00')) BETWEEN {$fromDate} AND $toDate")
            ->groupBy('date', 'ordered_date', 'cid')
            ->orderByRaw("ordered_date ASC, total DESC")
            ->get()
        ;
        $reportByDate = [];
        $campaigns = [];
        foreach ($data as $item) {
            @list($campaign, $medium, $source) = explode('.', $item->cid);
            if (!$campaign) $campaign = 'not-set';
            if (!$medium) $medium = 'not-set';
            if (!$source) $source = 'not-set';
            if (!isset($reportByDate[$item->date])) {
                $reportByDate[$item->date] = [
                    'total' => 0,
                    'details' => []
                ];
            }
            $group = $source . "." . $medium;
            $reportByDate[$item->date]['details']["{$campaign}.$group"] = $item->total;
            $reportByDate[$item->date]['total'] += $item->total;
            if (!isset($campaigns[$campaign]) || !in_array($group, $campaigns[$campaign])) {
                $campaigns[$campaign][] = $group;
            }
        }

        return [
            $reportByDate,
            $campaigns
        ];
    }
}
