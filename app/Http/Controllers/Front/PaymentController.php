<?php

namespace App\Http\Controllers\Front;

use App\Contract\CardPaymentInterface;
use App\Models\Payment;
use App\Repository\PaymentRepository;
use App\Services\DiscordWebHookClient;
use App\Services\JXApiClient;
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
        $now = time();
        $startMaintenance = (\DateTime::createFromFormat('Y-m-d H:i', date('Y-m-d 16:25')))->getTimestamp();
        $endMaintenance = (\DateTime::createFromFormat('Y-m-d H:i', date('Y-m-d 16:55')))->getTimestamp();
        if ($now > $startMaintenance && $now < $endMaintenance) {
            return response()->json(["error" => 'Server đang trong thời gian bảo trì định kỳ, vui lòng thử lại sau 17:00H.']);
        }
        $card = $this->createCardInstance();
        $error = $this->validateCard($card, $paymentRepository);
        if ($error) {
            return response()->json(['error' => $error]);
        }
        /** @var CardPaymentInterface $cardPayment */
        $cardPayment = app(CardPaymentInterface::class);
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
                return response()->json(["error" => implode('<br/>', array_first($result->getErrors()))]);
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
        $response = [
            'status' => false
        ];
        /** @var CardPaymentInterface $cardPayment */
        $cardPayment = app(CardPaymentInterface::class);
        $cardPayment->logCallbackRequest($request);
        $transactionCode = $cardPayment->getTransactionCodeFromCallback($request);
        if (!$transactionCode) {
            $response['message'] = "No transaction code found";
            $cardPayment->logCallbackProcessed($response['message']);
            return response()->json($response);
        }
        /** @var Payment $record */
        $record = $paymentRepository->getByTransactionCode($transactionCode);
        if (!$record) {
            $response['message'] = "Transaction not found";
            $cardPayment->logCallbackProcessed($response['message']);
            return response()->json($response, 404);
        }
        if (!empty($record->status)) {
            $response['message'] = "Transaction was processed successfully before";
            $cardPayment->logCallbackProcessed($response['message']);
            return response()->json($response);
        }
        list($status, $amount, $callbackCode) = $cardPayment->parseCallbackRequest($request);
        // add gold
        $paymentRepository->updateCardPaymentTransaction($record, $status, $cardPayment->getCallbackMessage($callbackCode), $amount);
        if ($status && empty($record->gold_added)) {
            $gamecoin = $record->gamecoin;
            $result = $gameApiClient->addGold($record->username, $gamecoin);
            $paymentRepository->updateRecordAddedGold($record, $result);
            $response['status'] = true;
        }
        $response['message'] = 'Processed';
        $cardPayment->logCallbackProcessed($response['message']);

        return response()->json($response);
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
        $alert = "";
        if ($stkDongA && strpos($message, "TK {$stkDongA}") !== false) {
            $alert = $parser->parseDongABankSms($message, $createdAt);
        } elseif ($stkVCB && strpos($message, "TK {$stkVCB}") !== false) {
            $alert = $parser->parseVietcomBankSms($stkVCB, $message, $createdAt);
        }

        if ($alert && !$parser->isSkippedMessage($message)) {
            $this->discord->send($alert);
        }
    }
}
