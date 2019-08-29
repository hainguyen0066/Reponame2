<?php

namespace App\Http\Controllers\Admin;

use App\Repository\PaymentRepository;
use App\Repository\UserRepository;
use App\User;
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
        'name', 'phone', 'note', 'id', 'email'
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
        if ($password = $request->get('password')) {
            $this->authorize('editPassword', $data);
            $userRepository->updatePassword($user, $password);
        }
        if ($password2 = $request->get('password2')) {
            $this->authorize('editPassword', $data);
            $userRepository->updatePassword2($user, $password2);
        }
        $user->fill(array_only($request->all(), ['name', 'phone', 'email', 'role_id', 'note']));
        $user->save();

        return $user;
    }

    protected function alterBreadBrowseEloquentQuery(\Illuminate\Database\Eloquent\Builder $query, Request $request)
    {
        $query->with(['payments', 'roles']);
    }

    protected function quickEdit(Request $request)
    {
        $slug = $this->getSlug($request);
        $field = $request->input('name');
        $value = $request->input('value');
        $id = $request->input('pk');
        $dataType = \Voyager::model('DataType')->where('slug', '=', $slug)->firstOrFail();
        if (!in_array($field, $this->getEditableFields())) {
            return response()->json(['errors' => ["You are not allowed to perform this action on field `{$field}``"]]);
        }
        // Check permission
        $this->authorize('edit', app($dataType->model_name));
        $userRepository = app(UserRepository::class);
        $user = User::findOrFail($id);
        if ($field == 'password' || $field == 'password2') {
            $this->authorize('editPassword', $user);
            if (!$value) {
                $value = substr(md5(time()), 0, 10);
            }
            if ($field == 'password') {
                $userRepository->updatePassword($user, $value);
            } else {
                $userRepository->updatePassword2($user, $value);
            }
        } else {
            $user->{$field} = $value;
            $user->save();
        }

        return response()->json(['success' => true, 'newValue' => $value]);
    }

    protected function getEditableFields()
    {
        return ['password', 'password2', 'phone', 'note'];
    }
}
