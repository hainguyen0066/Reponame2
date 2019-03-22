<?php

namespace App\Http\Controllers\Admin;

use App\Repository\UserRepository;
use App\User;
use TCG\Voyager\Http\Controllers\Controller;

/**
 * Class DashboardController
 *
 * @package \App\Http\Controllers\Admin
 */
class DashboardController extends Controller
{
    public function index(UserRepository $userRepository)
    {
        $fromDate = request('fromDate', date('Y-m-d', strtotime("-2 weeks")));
        $toDate = request('toDate', date('Y-m-d', strtotime('today')));
        $data = [
            'regToday'        => $userRepository->getTodayRegistered(),
            'regTotal'        => User::count(),
            'fromDate'        => $fromDate,
            'toDate'          => $toDate,
            'registeredChart' => $this->getRegisteredChartData($fromDate, $toDate),
        ];

        return \Voyager::view('voyager::index', $data);
    }

    private function getRegisteredChartData($fromDate, $toDate)
    {
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);
        list($reportData, $campaigns) = $userRepository->getUserRegisteredReport($fromDate, $toDate);
        // prepare chart data
        $registeredChartData = [
            'direct' => [],
            'mkt' => []
        ];
        $dateArray = [];
        foreach ($reportData as $date => $reportDatum) {
            $dateArray[] = $date;
            $direct = 0;
            $mkt = 0;
            foreach ($reportDatum['details'] as $cid => $total) {
                if ($cid == 'not-set.not-set.not-set') {
                    $direct += $total;
                } else {
                    $mkt += $total;
                }
            }
            $registeredChartData['direct'][] = $direct;
            $registeredChartData['mkt'][] = $mkt;
        }
        $data = [
            'dateArray'                  => $dateArray,
            'fromDate'                   => $fromDate,
            'toDate'                     => $toDate,
            'reportRegisteredByCampaign' => [
                'data'      => $reportData,
                'campaigns' => $campaigns,
            ],
            'registeredChartData'        => $registeredChartData,
        ];

        return $data;
    }
}
