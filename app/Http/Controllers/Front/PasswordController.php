<?php

namespace App\Http\Controllers\Front;

use Symfony\Component\HttpFoundation\Request;
use T2G\Common\Controllers\Front\BaseFrontController;
use T2G\Common\Repository\UserRepository;
use T2G\Common\Rules\SimplePassword;

/**
 * Class PasswordController
 *
 * @package \App\Http\Controllers\Front
 */
class PasswordController extends BaseFrontController
{
    const RULES_UPDATE_PASSWORD2 = [
        'old_password'  => 'required_without:old_password2',
        'old_password2' => 'required_without:old_password|string|min:6',
        'password2'     => 'required|string|min:6|confirmed',
    ];

    public function showChangePasswordForm()
    {
        $this->setMetaTitle("Đổi mật khẩu cấp 1");

        return view('pages.change_password');
    }

    public function showChangePassword2Form()
    {
        $this->setMetaTitle("Đổi mật khẩu cấp 2");

        return view('pages.change_password2');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \T2G\Common\Repository\UserRepository     $userRepository
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request, UserRepository $userRepository)
    {
        $validator = $this->validator($request->all(), $this->getPasswordRules());
        if (!$validator->passes()) {
            return $this->sendFailedResponse($request, $validator->getMessageBag()->toArray());
        }
        /** @var \T2G\Common\Models\AbstractUser $user */
        $user = \Auth::user();
        if (!$user->validatePassword($request->get('old_password'))) {
            return $this->sendFailedResponse($request, [
                'old_password' => ['Mật khẩu cũ không đúng']
            ]);
        }
        $userRepository->updatePassword($user, $request->get('password'));

        return back()->with('status', trans('Bạn đã đổi mật khẩu thành công'));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \T2G\Common\Repository\UserRepository     $userRepository
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function changePassword2(Request $request, UserRepository $userRepository)
    {
        $validator = $this->validator($request->all(), self::RULES_UPDATE_PASSWORD2);
        if (!$validator->passes()) {
            return $this->sendFailedResponse($request, $validator->getMessageBag()->toArray());
        }
        /** @var \T2G\Common\Models\AbstractUser $user */
        $user = \Auth::user();
        if ($user->password2) {
            if (!$user->validatePassword2($request->get('old_password2'))) {
                return $this->sendFailedResponse($request, [
                    'old_password2' => ['Mật khẩu cấp 2 cũ không đúng']
                ]);
            }
        } else {
            if (!$user->validatePassword($request->get('old_password'))) {
                return $this->sendFailedResponse($request, [
                    'old_password' => ['Mật khẩu cấp 1 không đúng']
                ]);
            }
        }
        $userRepository->updatePassword2($user, $request->get('password2'));

        return back()->with('status', trans('Bạn đã đổi mật khẩu cấp 2 thành công'));
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
     * @param       $rules
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data, $rules)
    {
        return \Validator::make($data, $rules);
    }

    private function getPasswordRules()
    {
        return [
            'old_password' => 'required|string|min:6',
            'password' => [
                'required',
                'string',
                'between:6,32',
                'confirmed',
                new SimplePassword(),
            ]
        ];
    }

}
