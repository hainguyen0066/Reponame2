<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\PaymentApiException;
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
use TCG\Voyager\Events\BreadDataUpdated;
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
        $this->addDataToAddEditView(true);

        return parent::create($request);
    }

    public function edit(Request $request, $id)
    {
        $this->addDataToAddEditView();

        return parent::edit($request, $id);
    }

    public function report(Request $request, PaymentRepository $paymentRepository)
    {
        $fromDate = $request->get('fromDate', date('Y-m-d', strtotime("-2 weeks")));
        $toDate = $request->get('toDate', date('Y-m-d', strtotime('today')));
        $revenue = $paymentRepository->getRevenueChartData($fromDate, $toDate);

        return view('voyager::payments.report', [
            'fromDate' => $fromDate,
            'toDate'   => $toDate,
            'revenue'  => $revenue,
            'todayRevenue' => $paymentRepository->getRevenueByPeriod(date('Y-m-d'), date('Y-m-d', strtotime("+1 day"))),
            'thisMonthRevenue' => $paymentRepository->getRevenueByPeriod(date('Y-m-01')),
        ]);
    }

    public function accept(Payment $payment, JXApiClient $JXApiClient, PaymentRepository $paymentRepository)
    {
        $this->authorize('edit', $payment);
        if (!Payment::isAcceptable($payment)) {
            $error = "Record đã ghi nhận thành công, hành động không được phép.";
            return $this->returnToListWithError($error, $payment->id);
        }

        list($knb, $xu) = $paymentRepository->exchangeGamecoin($payment->amount, $payment->payment_type);
        $addedGoldStatus = $JXApiClient->addGold($payment->username, $knb, $xu);

        if (!$addedGoldStatus) {
            $error = "Lỗi API nạp vàng, chưa add được vàng cho user";
            return $this->returnToListWithError($error, $payment->id);
        }
        $payment->gamecoin = $knb + $xu;
        $paymentRepository->setDone($payment);

        return redirect()
            ->route("voyager." . self::VOYAGER_SLUG . ".index")
            ->with([
                'message'    => "[#{$payment->id}] Cập nhật thành công",
                'alert-type' => 'success',
            ]);
    }

    private function addDataToAddEditView($isAdding = false)
    {
        \Voyager::onLoadingView('voyager::payments.edit-add', function ($view, &$params) use ($isAdding) {
            $types = Payment::getPaymentTypes();
            if ($isAdding) {
                unset($types[Payment::PAYMENT_TYPE_CARD]);
            }

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
            try {
                $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());
            } catch (PaymentApiException $e) {
                $payment = $e->getPaymentItem();
                GameApiLog::notify("Add vàng thất bại cho user `{$payment->username}` " . $e->getMessage(), [
                    'creator' => \Auth::user()->name,
                    'info' => array_only($payment->toArray(), ['id', 'amount', 'note']),
                ]);
                $error = 'Lỗi API nạp tiền';
                if ($request->ajax()) {
                    return response()->json(['errors' => ['note' => $error]]);
                } else {
                    return $this->returnToListWithError($error, $payment->id);
                }
            }

            event(new BreadDataAdded($dataType, $data));

            if ($request->ajax()) {
                return response()->json(['success' => true, 'data' => $data]);
            }

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with(
                    [
                        'message'    => "[#{$data->id}] " . __(
                                'voyager::generic.successfully_added_new'
                            ) . " {$dataType->display_name_singular}",
                        'alert-type' => 'success',
                    ]
                );
        }
    }

    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof Model ? $id->{$id->getKeyName()} : $id;

        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {
            try {
                $this->insertUpdateData($request, $slug, $dataType->editRows, $data);
            } catch (PaymentApiException $e) {
                $payment = $e->getPaymentItem();
                GameApiLog::notify("Add vàng thất bại cho user `{$payment->username}` " . $e->getMessage(), [
                    'creator' => \Auth::user()->name,
                    'info' => array_only($payment->toArray(), ['id', 'amount', 'note']),
                ]);
                return $this->returnToListWithError($request, $payment->id);
            }
            event(new BreadDataUpdated($dataType, $data));

            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => "[#{$data->id}] Cập nhật thành công",
                    'alert-type' => 'success',
                ]);
        }
    }

    /**
     * @param Request $request
     * @param         $slug
     * @param         $rows
     * @param         $data
     *
     * @return \App\Models\Payment
     * @throws \App\Exceptions\PaymentApiException
     */
    public function insertUpdateData($request, $slug, $rows, $data)
    {
        if (empty($data->id)) {
            // create new
            return $this->addNewPayment($request);
        } else {
            $input = array_only($request->all(), ['note', 'amount']);
            $data->fill($input);
            if (isset($input['amount'])) {
                /** @var PaymentRepository $paymentRepository */
                $paymentRepository = app(PaymentRepository::class);
                list($knb, $xu) = $paymentRepository->exchangeGamecoin($input['amount'], $data->payment_type);
                $data->gamecoin = $knb + $xu;
            }
            $data->save();

            return $data;
        }
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

    private function addNewPayment(Request $request)
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
            $extraData['pay_from'] = Payment::displayPaymentType($paymentType);
        }

        $payment = $paymentRepository->createPayment($user, $paymentType, $amount, $soxu, $extraData);
        /** @var JXApiClient $jxApi */
        $jxApi = app(JXApiClient::class);
        if ($addGoldStatus = $jxApi->addGold($user->name, $knb, $soxu)) {
            $paymentRepository->updateRecordAddedGold($payment, $addGoldStatus);
            $this->sendPaymentNotification($payment);
        } else {
            $exception = new PaymentApiException($jxApi->getLastResponse());
            $exception->setPaymentItem($payment);
            throw $exception;
        }

        return $payment;
    }
}
