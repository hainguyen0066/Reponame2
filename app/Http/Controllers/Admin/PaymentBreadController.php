<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Repository\PaymentRepository;
use App\Services\DiscordWebHookClient;
use App\Services\JXApiClient;
use App\User;
use App\Util\GameApiLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use Voyager;

/**
 * Class PaymentAdminController
 *
 * @package \App\Http\Controllers\Admin
 */
class PaymentBreadController extends VoyagerBaseController
{
    const VOYAGER_SLUG = 'payments';

    public function create(Request $request)
    {
        $this->addDataToAddEditView();

        return parent::create($request);
    }

    public function edit(Request $request, $id)
    {
        $this->addDataToAddEditView();

        return parent::edit($request, $id);
    }

    public function accept(Payment $payment, JXApiClient $JXApiClient, PaymentRepository $paymentRepository)
    {
        $this->authorize('edit', $payment);
        if (!Payment::isAcceptable($payment)) {
            $error = "Record đã ghi nhận thành công, hành động không được phép.";
            return $this->returnToListWithError($error, $payment->id);
        }
        $dataType = Voyager::model('DataType')->where('slug', '=', self::VOYAGER_SLUG)->first();

        list($knb, $xu) = $paymentRepository->exchangeGamecoin($payment->amount, $payment->payment_type);
        $addedGoldStatus = $JXApiClient->addGold($payment->username, $knb, $xu);

        if (!$addedGoldStatus) {
            $error = "Lỗi API nạp vàng, chưa add được vàng cho user";
            return $this->returnToListWithError($error, $payment->id);
        }

        $paymentRepository->setDone($payment);

        return redirect()
            ->route("voyager." . self::VOYAGER_SLUG . ".index")
            ->with([
                'message'    => "[#{$payment->id}] " . __('voyager::generic.successfully_updated')." {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }

    private function addDataToAddEditView()
    {
        \Voyager::onLoadingView('voyager::payments.edit-add', function ($view, &$params) {
            $types = Payment::getPaymentTypes();
            unset($types[Payment::PAYMENT_TYPE_CARD]);
            $params['paymentTypes'] = $types;
        });
    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));
        $rules = [
            'user_id' => 'required|exists:users,id',
            'payment_type' => ['required', Rule::in(array_keys(Payment::getPaymentTypes()))],
            'amount' => 'integer|gte:10000'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        if (!$request->has('_validate')) {
            $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
            if (!$data) {
                return response()->json(['errors' => ['note' => 'Lỗi API nạp tiền']]);
            }

            event(new BreadDataAdded($dataType, $data));

            if ($request->ajax()) {
                return response()->json(['success' => true, 'data' => $data]);
            }

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with(
                    [
                        'message'    => __(
                                'voyager::generic.successfully_added_new'
                            ) . " {$dataType->display_name_singular}",
                        'alert-type' => 'success',
                    ]
                );
        }
    }

    /**
     * @param Request $request
     * @param $slug
     * @param $rows
     * @param $data
     *
     * @return \App\Models\Payment
     */
    public function insertUpdateData($request, $slug, $rows, $data)
    {
        /** @var PaymentRepository $paymentRepository */
        $paymentRepository = app(PaymentRepository::class);
        $user = User::findOrFail($request->get('user_id'));
        $extraData = [];
        $paymentType = $request->get('payment_type');
        $amount = $request->get('amount');
        list($knb, $soxu) = $paymentRepository->exchangeGameCoin($amount, $paymentType);
        if ($note = $request->get('note')) {
            $extraData['note'] = $note;
        }

        $payment = $paymentRepository->createPayment($user, $paymentType, $amount, $soxu, $extraData);
        /** @var JXApiClient $jxApi */
        $jxApi = app(JXApiClient::class);
        if ($addGoldStatus = $jxApi->addGold($user->name, $knb, $soxu)) {
            $paymentRepository->updateRecordAddedGold($payment, $addGoldStatus);
            $this->sendPaymentNotification($payment);
        } else {
            GameApiLog::notify("Add vàng thất bại cho user `{$payment->username}` " . $jxApi->getLastResponse(), [
                'creator' => \Auth::user()->name,
                'info' => array_only($payment->toArray(), ['id', 'amount', 'note']),
            ]);
            return false;
        }

        return $payment;
    }

    public function history(User $user, Request $request)
    {
        $paymentRepository = app(PaymentRepository::class);
        $histories = $paymentRepository->getUserPaymentHistory($user);

        return view('vendor.voyager.payment.read', [
            'histories' => $histories,
        ]);
    }

    private function sendPaymentNotification(Payment $payment)
    {
        $paymentTypes = Payment::getPaymentTypes();
        $now = date('Y-m-d H:i:s');
        $text = "[". $paymentTypes[$payment->payment_type] ."] `{$payment->creator->name}` add vào tài khoản `{$payment->username}` `{$payment->gamecoin} Xu` vào lúc {$now}.";
        if ($payment->note) {
            $text .= " Ghi chú: {$payment->note}";
        }

        if (env('APP_ENV') != 'prod') {
            GameApiLog::notify($text);
        } else {
            $discord = new DiscordWebHookClient(env('DISCORD_ADD_GOLD_WEBHOOK_URL'));
            $discord->send($text);
        }

    }

    /**
     * @param string $error
     * @param        $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function returnToListWithError(string $error, $id)
    {
        return redirect()
            ->route("voyager." . self::VOYAGER_SLUG . ".index")
            ->with([
                'message'    => "[#{$id}] {$error}",
                'alert-type' => 'error',
            ]);
    }
}
