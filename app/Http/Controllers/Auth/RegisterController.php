<?php

namespace App\Http\Controllers\Auth;

use App\Repository\UserRepository;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|regex:/^[a-z0-9]{5,50}$/i|unique:users',
            'phone'    => 'nullable|digits_between:10,14',
            'password' => 'required|string|between:6,32|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        /** @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);

        return $userRepository->registerUser(array_only($data, ['name', 'password', 'phone']));
    }

    /**
     * @return string
     */
    protected function redirectTo()
    {
        return route('front.home');
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(\Illuminate\Http\Request $request, $user)
    {
        $user->registered_ip = $request->getClientIp();
        // save tracking
        $this->updateTracking($user);
        $user->save();
        if ($request->ajax()) {
            return response()->json([
                'auth' => auth()->check(),
                'user' => $user,
                'intended' => $this->redirectPath(),
            ]);
        }
    }

    private function updateTracking($user)
    {
        $trackingCookies = ['utm_source', 'utm_medium', 'utm_campaign'];
        foreach ($trackingCookies as $cookieName) {
            if ($value = \Cookie::get($cookieName)) {
                $user->{$cookieName} = $value;
            }
        }
    }
}
