<?php

namespace App\Http\Controllers\Front;

use App\User;
use Hash;
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

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changePassword(Request $request)
    {
        $validator = $this->validator($request->all());
        if (!$validator->passes()) {
            return $this->sendFailedResponse($request, $validator->getMessageBag()->toArray());
        }
        $user = \Auth::user();
        $this->updatePassword($request, $user);

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

    private function updatePassword(Request $request, User $user)
    {
        $user->password = Hash::make($request->get('password'));
        $user->save();
    }
}
