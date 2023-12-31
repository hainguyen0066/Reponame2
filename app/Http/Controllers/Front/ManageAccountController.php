<?php

namespace App\Http\Controllers\Front;

use Symfony\Component\HttpFoundation\Request;
use T2G\Common\Controllers\Front\BaseFrontController;
use T2G\Common\Repository\PaymentRepository;
use T2G\Common\Repository\UserRepository;
use T2G\Common\Rules\SimplePassword;

/**
 * Class ManageAccount
 *
 * @package \App\Http\Controllers\Front
 */
class ManageAccountController extends BaseFrontController
{
    const LIMIT_PAYMENT_HISTORY = 30;

    public function getAccountInfo()
    {
        $this->setMetaTitle("Thông tin tài khoản");

        return view('pages.account_info');
    }

    public function historyCharge(PaymentRepository $paymentRepository)
    {
        $histories = $paymentRepository->getUserPaymentHistory(\Auth::user(), self::LIMIT_PAYMENT_HISTORY);
        $this->setMetaTitle("Lịch sử giao dịch");

        return view('pages.history_charge', ['histories' => $histories]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \T2G\Common\Repository\UserRepository     $userRepository
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request, UserRepository $userRepository)
    {
        $validator = $this->validator($request->all());
        if (!$validator->passes()) {
            return $this->sendFailedResponse($request, $validator->getMessageBag()->toArray());
        }
        $user = \Auth::user();
        $userRepository->updatePassword($user, $request->get('password'));

        return back()->with('status', trans('Bạn đã đổi mật khẩu thành công'));
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param array                                     $errors
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendFailedResponse(Request $request, array $errors)
    {
        return redirect()->back()
            ->withInput($request->all())
            ->withErrors($errors);
    }

    /**
     * @param array $data
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Validator::make($data, [
            'old_password' => 'required|string|min:6',
            'password' => [
                'required',
                'string',
                'between:6,32',
                'confirmed',
                new SimplePassword(),
            ]
        ]);
    }
}
