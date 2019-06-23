<?php

namespace App\Http\Controllers\Admin;

use App\Repository\PaymentRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use Validator;

/**
 * Class UserBreadController
 *
 * @package \App\Http\Controllers\Admin
 */
class UserBreadController extends VoyagerBaseController
{
    protected $searchable = [
        'name', 'phone', 'id', 'created_at'
    ];

    public function edit(Request $request, $id)
    {
        \Voyager::onLoadingView('voyager::users.edit-add', function ($view, &$params) {
            /** @var PaymentRepository $paymentRepository */
            $paymentRepository = app(PaymentRepository::class);
            if (!empty($params['dataTypeContent'])) {
                $params['histories'] = $paymentRepository->getUserPaymentHistory($params['dataTypeContent']);
            }
        });

        return parent::edit($request, $id);
    }

    public function validateBread($request, $data, $name = null, $id = null)
    {
        $rules = [];
        if (!empty($request['password'])) {
            $rules['password'] = 'between:6,32';
        }

        if (!empty($request['password2'])) {
            $rules['password2'] = 'between:6,32';
        }

        return Validator::make($request, $rules);
    }

    public function insertUpdateData($request, $slug, $rows, $data)
    {
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);
        /** @var \App\User $user */
        $user = $data;
        $user->fill(array_only($request->all(), ['name', 'phone', 'email', 'role_id']));
        if ($password = $request->get('password')) {
            $userRepository->updatePassword($user, $password);
        }
        if ($password2 = $request->get('password2')) {
            $userRepository->updatePassword2($user, $password2);
        }
        if (!$password && !$password2) {
            $user->save();
        }

        return $user;
    }
}
