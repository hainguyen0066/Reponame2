<?php

namespace App\Http\Controllers\Front;

use App\Repository\PageRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
