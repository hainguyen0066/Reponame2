<?php

namespace App\Http\Controllers\Front;

use App\Models\Server;
use App\Repository\ServerRepository;
use App\Services\GameApiClient;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServerController extends BaseFrontController
{
    public function play(Server $server, $serverName, GameApiClient $gameApiClient)
    {
        if (!request('v') && strpos(url()->current(), 'https') !== false) {
            return redirect(
                str_replace('https', 'http', url()->current() . "?v=" . time())
            );
        }
        $user = \Auth::user();
        $playUrl = $gameApiClient->getUrlPlayGame($user->id, $user->name, $server->game_server_id);

        return view('pages.play_game', [
            'server' => $server,
            'user'   => $user,
            'url'    => $playUrl,
        ]);
    }

    public function playTest(Server $server, $serverName, GameApiClient $gameApiClient)
    {
        if (!request('v') && strpos(url()->current(), 'https') !== false) {
            return redirect(
                str_replace('https', 'http', url()->current() . "?v=" . time())
            );
        }
        $user = \Auth::user();
        $playUrl = $gameApiClient->getUrlPlayGame($user->id, $user->name, $server->game_server_id);
        return view('pages.play_game', [
            'server' => $server,
            'user'   => $user,
            'url'    => str_replace('https:', 'http:', $playUrl),
        ]);
    }

    /**
     * @param \App\Repository\ServerRepository $serverRepository
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function playNow(ServerRepository $serverRepository)
    {
        $serverPlayNow = setting('site.server_play_now', 1);
        $serverRepository->findByGameServerId($serverPlayNow);
        $server = Server::findOrFail($serverPlayNow);

        return redirect(route('front.server.play', [$server->id, "S{$server->id}-{$server->slug}"]));
    }

    /**
     * @param \App\Services\GameApiClient $gameApiClient
     */
    public function getCCU(GameApiClient $gameApiClient)
    {
        $user = \Auth::user();
        if (!$user->hasRole(['admin', 'editor'])) {
            throw new NotFoundHttpException();
        }
        $ccus = $gameApiClient->getCcu();
        foreach ($ccus->data as $server => $ccu) {
            dump($server . ": $ccu");
        }
    }
}
