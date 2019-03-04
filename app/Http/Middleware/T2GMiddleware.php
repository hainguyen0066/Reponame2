<?php

namespace App\Http\Middleware;

use App\Repository\ServerRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Class BlackListIp
 *
 * @package \App\Http\Middleware
 */
class T2GMiddleware
{
    protected $except = ['/'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (
            time() < strtotime('2018-12-28 11:00:00')
            && $request->getMethod() == Request::METHOD_GET
            && setting('site.front_page_forbidden')
            && !in_array($request->getPathInfo(), $this->except)
        ) {
            $user = \Auth::user();
            if (!$user || !$user->hasRole(['admin', 'editor'])) {
                throw new ServiceUnavailableHttpException(null, "Vui lòng quay lại vào ngày 28-12 để tham gia Open Beta Kiếm Thế Web");
            }
        }

        \View::share('user', \Auth::user());
        $serverRepository = app(ServerRepository::class);
        $servers = $serverRepository->getAvailableServers();
        \View::share('servers', $servers);
        \View::share('serverPlayNow', $serverRepository->getServerPlayNow());

        return $next($request);
    }
}
