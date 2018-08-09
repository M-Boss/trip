<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 7/31/18
 * Time: 5:15 PM
 */
namespace App\Repositories\Users;

use App\Events\UserCreated;
use App\User;

class UsersDatabase implements Users {

    public function create($user){
        $user->save();
        event(new UserCreated($user));
        return $user;
    }

    /**
     * @param $user \App\User
     */
    public function generateOTP($user){

        $user->generateOTP();
        $user->update(['otp', 'otp_expiration']);
    }


    public function attemptOTP($mobile, $otp)
    {
        return User::where('mobile', $mobile)->where('otp', $otp)->where('otp_expiration', '>', time())->first();
    }
}