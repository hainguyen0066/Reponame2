<?php

namespace App\Http\Controllers\Front;

use App\Contract\CardPaymentInterface;
use App\Models\Payment;
use App\Repository\PaymentRepository;
use App\Services\DiscordWebHookClient;
use App\Services\JXApiClient;
use App\Services\NapTheNhanhPayment;
use App\Services\RecardPayment;
use App\Services\T2GNotifierParser;
use App\Util\MobileCard;
use Illuminate\Http\Request;

/**
 * Class PaymentController
 *
 * @package \App\Http\Controllers\Front
 */
class PaymentController extends BaseFrontController
{
    /**
     * @var \App\Services\DiscordWebHookClient
     */
    protected $discord;

    public function __construct()
    {
        parent::__construct();
        $this->discord = new DiscordWebHookClient(env('DISCORD_ZING_WEBHOOK_URL'));
    }

    public function index()
    {
       return redirect(route('front.static.nap_the_cao'));
    }

    public function submitCard(PaymentRepository $paymentRepository)
    {
        $user = \Auth::user();
        if (!$user) {
            return response()->json(["error" => 'Vui lòng đăng nhập lại để tiếp tục thao tác', 'relogin' => true]);
        }
        if ($this->isInMaintenancePeriod()) {
            return response()->json(["error" => 'Server đang trong thời gian bảo trì định kỳ, vui lòng thử lại sau 17:00H.']);
        }

        $card = $this->createCardInstance();
        $error = $this->validateCard($card, $paymentRepository);
        if ($error) {
            return response()->json(['error' => $error]);
        }
        $cardPayment = $this->getCardPaymentService();
        list($knb, $soxu) = $paymentRepository->exchangeGamecoin($card->getAmount(), Payment::PAYMENT_TYPE_CARD);
        $payment = $paymentRepository->createCardPayment($user, $card, $knb);
        if ($card->getType() == MobileCard::TYPE_ZING){
            $this->discord->send("`{$user->name}` vừa submit 1 thẻ Zing `" . $card->getAmount() / 1000 . "k`");
        } else {
            $result = $cardPayment->useCard($card, $payment->getKey());
            if ($result->isSuccess() && $transactionCode = $result->getTransactionCode()) {
                $paymentRepository->updateCardPayment($payment, $transactionCode);
            } else {
                $cardPayment->logCardPaymentError($result);
                return response()->json(["error" => implode('<br/>', $result->getErrors())]);
            }
        }

        return response()->json(["msg" => 'Thẻ đang được xử lý... Vui lòng đợi vài phút, hệ thống sẽ tự cộng Xu nếu xử lý thành công.']);
    }

    protected function validateCard(MobileCard $card, PaymentRepository $paymentRepository)
    {
        if(!$card->getCode() || !$card->getSerial() || !$card->getType() || !$card->getAmount()){
            return "Vui lòng điền đầy đủ thông tin.";
        }
        // check đúng định dạng the Mobi: seri 15, ma 12. Zing: seri 12, ma:9. vcoin 12-12
        $checkCardFormat = true;
        if ($card->getType() == 'MOBIFONE') {
            if (strlen($card->getCode()) != 12 || strlen($card->getSerial()) != 15) {
                $checkCardFormat = false;
            }
        }
        if ($card->getType() == 'ZING') {
            if (strlen($card->getCode()) < 9 || strlen($card->getSerial()) != 12) {
                $checkCardFormat = false;
            }
        }
        if ($card->getType() == 'VINA') {
            if (strlen($card->getCode()) < 12 || strlen($card->getSerial()) < 12) {
                $checkCardFormat = false;
            }
        }
        if ($card->getType() == 'VIETTEL') {
            if (strlen($card->getCode()) < 12 || strlen($card->getSerial()) < 11) {
                $checkCardFormat = false;
            }
        }
        if (!$checkCardFormat) {
            return "Thẻ định dạng không đúng. Vui lòng kiểm tra lại.";
        }
        if($paymentRepository->isCardExisted($card)){
            return  "Thẻ đã có trong hệ thống.";
        }

        return false;
    }

    public function cardPaymentCallback(PaymentRepository $paymentRepository, JXApiClient $gameApiClient, Request $request)
    {
        $this->getCardPaymentService();
        $cardPayment = $this->getCardPaymentServiceForCallback($request);
        $cardPayment->logCallbackRequest($request);
        $transactionCode = $cardPayment->getTransactionCodeFromCallback($request);
        if (!$transactionCode) {
            return $this->responseForCallback($cardPayment, "No transaction code found");
        }
        $record = $paymentRepository->getByTransactionCode($transactionCode);
        if (!$record) {
            return $this->responseForCallback($cardPayment, "Transaction not found", 404);
        }
        if (!empty($record->status)) {
            return $this->responseForCallback($cardPayment, "Transaction was processed successfully before");
        }

        // add gold
        $responseStatus = false;
        list($status, $amount, $callbackCode) = $cardPayment->parseCallbackRequest($request);
        $paymentRepository->updateCardPaymentTransaction($record, $status, $cardPayment->getCallbackMessage($callbackCode), $amount);
        if ($status && empty($record->gold_added)) {
            $gamecoin = $record->gamecoin;
            $result = $gameApiClient->addGold($record->username, $gamecoin);
            $paymentRepository->updateRecordAddedGold($record, $result);
            $responseStatus = true;
        }

        return $this->responseForCallback($cardPayment, "Processed", 200, $responseStatus);
    }

    /**
     * @return \App\Util\MobileCard
     */
    private function createCardInstance()
    {
        $type   = trim(request('card_type'));
        $amount = intval(trim(request('card_amount')));
        $serial = str_replace(" ","",trim(request('card_serial')));
        $serial = str_replace("-","",$serial);
        $pin = str_replace(" ","",trim(request('card_pin')));
        $pin = str_replace("-","",$pin);
        $card = new MobileCard();
        $card->setType($type)
            ->setCode($pin)
            ->setSerial($serial)
            ->setAmount($amount)
        ;

        return $card;
    }

    /**
     * Received Internet Banking SMS alert from T2G_Notifier Android app and send to Discord webhook
     *
     * @param \App\Services\T2GNotifierParser $parser
     */
    public function alertTransaction(T2GNotifierParser $parser)
    {
        $message = request('message');
        $createdAt = request('createdAt');
        if (!$message) {
            exit();
        }
        $stkDongA = env('BANKING_ACCOUNT_DONGA');
        $stkVCB = env('BANKING_ACCOUNT_VIETCOMBANK');
        if ($stkDongA && strpos($message, "TK {$stkDongA}") !== false) {
            $alert = $parser->parseDongABankSms($message, $createdAt);
        } elseif ($stkVCB && strpos($message, "TK {$stkVCB}") !== false) {
            $alert = $parser->parseVietcomBankSms($stkVCB, $message, $createdAt);
        } else {
            $alert = $parser->parseFptShopSms($message, $createdAt);
        }

        if ($alert && !$parser->isSkippedMessage($message)) {
            $this->discord->send($alert);
        }
    }

    /**
     * @return bool
     */
    private function isInMaintenancePeriod()
    {
        $now = time();
        $startMaintenance = (\DateTime::createFromFormat('Y-m-d H:i', date('Y-m-d 16:25')))->getTimestamp();
        $endMaintenance = (\DateTime::createFromFormat('Y-m-d H:i', date('Y-m-d 16:55')))->getTimestamp();

        return $now > $startMaintenance && $now < $endMaintenance;
    }

    /**
     * @return \App\Contract\CardPaymentInterface
     */
    private function getCardPaymentService()
    {
        $autoSwitch = boolval(\Voyager::setting('site.card_payment_auto_switch', false));
        // auto switch handle
        $hour = intval(date('G'));
        if ($autoSwitch && ($hour > 21 || $hour < 9)) {
            return app(env('CARD_PAYMENT_PARTNER_POS2', NapTheNhanhPayment::class));
        }

        return app(CardPaymentInterface::class);
    }

    /**
     * Create CardPaymentInterface based on callback request
     * @param \Illuminate\Http\Request $request
     * @return \App\Contract\CardPaymentInterface
     */
    private function getCardPaymentServiceForCallback(Request $request)
    {
        if ($request->get('secret_key') && $request->get('transaction_code')) {
            return app(RecardPayment::class);
        }
        if ($request->get('tranid')) {
            return app(NapTheNhanhPayment::class);
        }

        return app(CardPaymentInterface::class);
    }

    /**
     * @param \App\Contract\CardPaymentInterface $cardPayment
     * @param                                    $message
     * @param int                                $statusCode
     * @param bool                               $responseStatus
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function responseForCallback(CardPaymentInterface $cardPayment, $message, $statusCode = 200, $responseStatus = false)
    {
        $response = [
            'status'  => $responseStatus,
            'message' => $message,
        ];
        $cardPayment->logCallbackProcessed($message);

        return response()->json($response, $statusCode);
    }
}
