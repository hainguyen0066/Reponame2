<?php

namespace App\Http\Controllers\Front;


/**
 * Class SupportController
 *
 * @package \App\Http\Controllers\Front
 */
class SupportController extends BaseFrontController
{
    public function index()
    {
        $this->setMetaTitle('Hỗ trợ');
        $user = \Auth::user();
        $s01Url = env('S01_BASE_URL', 'http://s01.test');
        $teamId = env('S01_TEAM_ID', 'fxqojx5t7by8d8p6js47enukwe');
        $url = "{$s01Url}/{$teamId}/support?username=" . strtolower($user->name);

        return view('pages.support', ['url' => $url]);
    }
}
