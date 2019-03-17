<?php

namespace App\Observers;

use App\Repository\UserRepository;
use App\Services\JXApiClient;
use App\User;

class UserObserver
{
    public static $updatedPasswordFlag = [];

    public static $updatedPassword2Flag = [];

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var JXApiClient
     */
    protected $gameApiClient;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
        $this->gameApiClient = app(JXApiClient::class);
    }

    private function _setPasswordForGame(User $user)
    {
        $apiResult = $this->gameApiClient->setPassword($user->name, $user->getRawPassword());
        if (!$apiResult) {
            //log error
            \Log::channel('game_api')->critical("Cannot set password for user `{$user->name}`", [
                'api_response' => $this->gameApiClient->getLastResponse(),
                'user' => array_only($user->toArray(), ['id', 'name'])
            ]);
        }

        return true;
    }

    private function _setPassword2ForGame(User $user)
    {
        $apiResult = $this->gameApiClient->setSecondaryPassword($user->name, $user->getRawPassword2());
        if (!$apiResult) {
            //log error
            \Log::channel('game_api')->critical("Cannot set password 2 for user `{$user->name}`", [
                'api_response' => $this->gameApiClient->getLastResponse(),
                'user' => array_only($user->toArray(), ['id', 'name'])
            ]);
        }

        return true;
    }

    private function _createUserForGame(User $user)
    {
        $apiResult = $this->gameApiClient->createUser($user->name, $user->getRawPassword());
        if (!$apiResult) {
            \Log::channel('game_api')->critical("Cannot create account for user `{$user->name}`", [
                'api_response' => $this->gameApiClient->getLastResponse(),
                'user' => array_only($user->toArray(), ['id', 'name'])
            ]);
        }

        return true;
    }
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        if (in_array($user->name, self::$updatedPasswordFlag)) {
            return null;
        }
        $this->_createUserForGame($user);
        self::$updatedPasswordFlag[] = $user->name;
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $changes = $user->getChanges();
        $this->checkForUpdatingPassword($user, $changes);
        $this->checkForUpdatingPassword2($user, $changes);
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }

    private function checkForUpdatingPassword(User $user, array $changes)
    {
        if (in_array($user->name, self::$updatedPasswordFlag)) {
            return false;
        }

        if (isset($changes['raw_password'])) {
            $newPassword = \Hash::make(base64_decode($changes['raw_password']));
            $this->_setPasswordForGame($user);
            self::$updatedPasswordFlag[] = $user->name;
            if ($newPassword != $user->getAuthPassword()) {
                $user->password = $newPassword;
                $user->save();
            }
        }
    }

    private function checkForUpdatingPassword2(User $user, array $changes)
    {
        if (in_array($user->name, self::$updatedPassword2Flag)) {
            return false;
        }
        if (isset($changes['password2'])) {
            $this->_setPassword2ForGame($user);
            self::$updatedPassword2Flag[] = $user->name;
        }
    }
}
