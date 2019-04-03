<?php

namespace App\Http\Controllers\Front;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PasswordController
 *
 * @package \App\Http\Controllers\Front
 */
class PasswordController extends BaseFrontController
{
    const RULES_UPDATE_PASSWORD = [
        'old_password' => 'required|string|min:6',
        'password'     => 'required|string|min:6|confirmed',
    ];

    const RULES_UPDATE_PASSWORD2 = [
        'old_password'  => 'required_without:old_password2',
        'old_password2' => 'required_without:old_password|string|min:6',
        'password2'     => 'required|string|min:6|confirmed',
    ];

    public function showChangePasswordForm()
    {
        return view('pages.change_password');
    }
    public function showChangePassword2Form()
    {
        return view('pages.change_password2');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Repository\UserRepository            $userRepository
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changePassword(Request $request, UserRepository $userRepository)
    {
        $validator = $this->validator($request->all(), self::RULES_UPDATE_PASSWORD);
        if (!$validator->passes()) {
            return $this->sendFailedResponse($request, $validator->getMessageBag()->toArray());
        }
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
     * @param \App\Repository\UserRepository            $userRepository
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changePassword2(Request $request, UserRepository $userRepository)
    {
        $validator = $this->validator($request->all(), self::RULES_UPDATE_PASSWORD2);
        if (!$validator->passes()) {
            return $this->sendFailedResponse($request, $validator->getMessageBag()->toArray());
        }
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
     *
     * @return \Illuminate\Validation\Validator
     */
    protected function validator(array $data, $rules)
    {
        return \Validator::make($data, $rules);
    }

}
