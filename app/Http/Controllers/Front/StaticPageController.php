<?php

namespace App\Http\Controllers\Front;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use T2G\Common\Controllers\Front\BaseFrontController;
use T2G\Common\Repository\PageRepository;

/**
 * Class StaticPageController
 *
 * @package \App\Http\Controllers\Front
 */
class StaticPageController extends BaseFrontController
{
    public function detail(PageRepository $pageRepository)
    {
        $uri = trim(request()->route()->uri());
        $page = $pageRepository->getPageByUri($uri);
        if (!$page) {
            throw new NotFoundHttpException();
        }

        $this->setMetaTitle($page->title);

        return view('pages.static_page', ['page' => $page]);
    }
}
