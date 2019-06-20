<?php

namespace App\Http\Controllers\Front;

use App\Models\Payment;
use App\Repository\PaymentRepository;
use App\Services\DiscordWebHookClient;
use App\Services\JXApiClient;
use App\Services\RecardPayment;
use App\Util\MobileCard;

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
        $recard = new RecardPayment(
            env('RECARD_MERCHANT_ID'),
            env('RECARD_SECRET_KEY')
        );
        list($knb, $soxu) = $paymentRepository->exchangeGamecoin($card->getAmount(), Payment::PAYMENT_TYPE_CARD);
        $payment = $paymentRepository->createCardPayment($user, $card, $knb);
        if ($card->getType() == MobileCard::TYPE_ZING){
            $this->discord->send("`{$user->name}` vừa submit 1 thẻ Zing `" . $card->getAmount() / 1000 . "k`");
        } else {
            $result = $recard->useCard($card);
            if ($result->isSuccess() && $transactionCode = $result->getTransactionCode()) {
                $paymentRepository->updateRecardPayment($payment, $transactionCode);
            } else {
                return response()->json(["error" => implode('<br/>', array_first(array_values($result->getErrors())))]);
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

    public function recardCallback(PaymentRepository $paymentRepository, JXApiClient $gameApiClient)
    {
        $response = [
            'status' => false
        ];
        $transactionCode = request('transaction_code');
        $status = intval(request('status'));
        $reason = request('reason');
        $amount = request('amount');
//        $comment = request('comment');
        $secretKey = request('secret_key');
        $posts = request();
        if (isset($posts['secret_key'])) {
            unset($posts['secret_key']);
        }
        if (!$transactionCode || $secretKey != env('RECARD_SECRET_KEY')) {
            return response()->json($response);
        }
        $record = $paymentRepository->getByTransactionCode($transactionCode);
        if (!$record) {
            $record['message'] = "Transaction not found";
            return response()->json($response, 404);
        }
        if (!empty($record->status)) {
            $record['message'] = "Transaction was processed successfully before";
            return response()->json($response);
        }
        // add gold
        $recardStatus = $status === 1 ? true : false;
        $paymentRepository->updateRecardTransaction($record, $status, $reason, $amount);
        if (!$recardStatus) {
            return response()->json($response);
        }
        if ($recardStatus && empty($record->gold_added)) {
            $gamecoin = $record->gamecoin;
            $result = $gameApiClient->addGold($record->username, $gamecoin);
            $paymentRepository->updateRecordAddedGold($record, $result);
        }
        $response = [
            'status' => true,
            'message' => 'Processed'
        ];

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

    public function alertTransaction()
    {
        $sender = request('sender');
        $message = request('message');
        $createdAt = request('createdAt');
        \Log::info("Banking Alert received: Sender {$sender}, message: {$message}");
        if (!$message) {
            exit();
        }
        $stkDongA = env('BANKING_ACCOUNT_DONGA');
        $stkVCB = env('BANKING_ACCOUNT_VIETCOMBANK');
        $alert = "";
        if ($stkDongA && strpos($message, "TK {$stkDongA}") !== false) {
            //DongA Bank thong bao: TK 0110666501 da thay doi: +200,000 VND. Nop tien mat(NGUYEN VAN LOI NOP TM-LONG NHAN 11). So du hien tai la:...
            $beginOfAmount = strpos($message, 'da thay doi: +') + 14;
            $endOfAmount = strpos(substr($message, $beginOfAmount), 'VND');
            $amount = trim(substr($message, $beginOfAmount, $endOfAmount));
            $note = trim(substr($message, $beginOfAmount + $endOfAmount + 4));
            $note = trim(substr($note, 0, strpos($note, "So du hien tai")));
            $alert = "[Đông Á Bank] Nhận được số tiền `{$amount}` vào lúc `{$createdAt}`. Nội dung: `{$note}`";

        } elseif ($stkVCB && strpos($message, "TK {$stkVCB}") !== false) {
            //SD TK 0071001400512 +200,000VND luc 19-06-2019 20:50:40. SD 83,157,241VND. Ref IBVCB.1906190052065001.dangthanhhai
            $beginOfAmount = strpos($message, "TK {$stkVCB} +") + 18;
            $endOfAmount = strpos(substr($message, $beginOfAmount), 'VND');
            $amount = trim(substr($message, $beginOfAmount, $endOfAmount));
            $note = trim(substr($message, strpos($message, '. Ref') + 6));
            $alert = "[Vietcombank] Nhận được số tiền `{$amount}` vào lúc `{$createdAt}`. Nội dung: `{$note}`";
        }

        if ($alert) {
            $this->discord->send($alert);
        }
    }
}
