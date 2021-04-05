<?php

namespace App\Http\Controllers\Front;

use T2G\Common\Controllers\Front\BaseFrontController;
use T2G\Common\Controllers\Traits\GiftCodeControllerTrait;
use T2G\Common\Repository\PageRepository;

/**
 * Class GiftCodeController
 *
 * @package \App\Http\Controllers\Front
 */
class GiftCodeController extends BaseFrontController
{
    use GiftCodeControllerTrait;

    /**
     * @param \T2G\Common\Repository\PageRepository $pageRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(PageRepository $pageRepository)
    {
        $pageContent = $pageRepository->getPageByUri('nhap-code');

        return view('pages.use_code', ['page' => $pageContent]);
    }
}
