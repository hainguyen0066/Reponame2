<?php

namespace App\Http\Controllers\Front;

use T2G\Common\Controllers\Front\BaseFrontController;
use T2G\Common\Exceptions\GiftCodeException;
use T2G\Common\Repository\PageRepository;
use T2G\Common\Requests\UseCodeRequest;
use T2G\Common\Services\GiftCodeService;

/**
 * Class GiftCodeController
 *
 * @package \App\Http\Controllers\Front
 */
class GiftCodeController extends BaseFrontController
{
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

    /**
     * @param \T2G\Common\Requests\UseCodeRequest  $request
     * @param \T2G\Common\Services\GiftCodeService $giftCodeService
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function useCode(UseCodeRequest $request, GiftCodeService $giftCodeService)
    {
        /** @var \App\User $user */
        $user = \Auth::user();
        $data = $request->validated();
        $error = '';
        try {
            $giftCodeItem = $giftCodeService->getGiftCodeItem($data['code']);
            $added = $giftCodeService->useCode($user, $giftCodeItem);
            if (!$added) {
                $error = trans("gift_code.race_condition_error");
            }
        } catch (GiftCodeException $e) {
            $error = trans("gift_code." . $e->getMessage());
            if ($e->getCode() == GiftCodeException::ERROR_CODE_API_ERROR) {
                \Log::critical("Cannot add code for user `{$user->name}`", $e->getGiftCode()->toArray());
            }
        }
        if ($error) {
            return back()->withErrors(['code' => $error]);
        }

        return back()->with('status', trans("gift_code.used_code_successfully"));
    }
}
