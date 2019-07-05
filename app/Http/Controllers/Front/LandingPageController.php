<?php

namespace App\Http\Controllers\Front;

use App\Services\NapTheNhanhPayment;
use App\Util\MobileCard;

/**
 * Class LandingPageController
 *
 * @package \App\Http\Controllers\Front
 */
class LandingPageController extends BaseFrontController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {

        $cardPayment = new NapTheNhanhPayment(env('NAPTHENHANH_PARTNER_ID'), env('NAPTHENHANH_PARTNER_KEY'));
        $card = new MobileCard();
        $card->setType(MobileCard::TYPE_VIETTEL)
            ->setCode('015898598072706')
            ->setSerial('10003361644306')
            ->setAmount(50000)
        ;
        $t = time();
        $rs = $cardPayment->useCard($card, $t);
        dd($rs);

        if (setting('site.landing_page_enabled')) {
            return view('pages.landing');
        }
        return view('pages.landing');
        return redirect(route('front.home'));
    }
}
