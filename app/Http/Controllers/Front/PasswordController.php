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
    public function showChangePasswordForm()
    {
        return view('pages.change_password');
    }
    public function changePass2()
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
        $validator = $this->validator($request->all());
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
            'password'     => 'required|string|min:6|confirmed',
        ]);
    }

}
