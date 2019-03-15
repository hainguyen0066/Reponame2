<?php

namespace App\Http\Controllers\Front;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ManageAccount
 *
 * @package \App\Http\Controllers\Front
 */
class ManageAccount extends BaseFrontController
{
    
    public function AccountInfo()
    {
        return view('pages.account_info');
    }
    public function changePass()
    {
        return view('pages.change_password');
    }
    public function changePass2()
    {
        return view('pages.change_password2');
    }
    public function historyCharge()
    {
        return view('pages.history_charge');
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
