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
        $data = [
            'reg_today' => $userRepository->getTodayRegistered(),
            'reg_full' => User::count()
        ];

        return \Voyager::view('voyager::index', $data);
    }
}
