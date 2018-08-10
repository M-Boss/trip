<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 7/31/18
 * Time: 5:15 PM
 */
namespace App\Repositories\Users;

use App\Events\OTPGenerated;
use App\Events\UserCreated;
use App\User;

class UsersDatabase implements Users {

    public function create($user){
        $this->generateOTP($user, false);
        $user->save();
        event(new UserCreated($user));
        return $user;
    }

    /**
     * @param $user \App\User
     * @param bool $updateDB
     */
    public function generateOTP($user, $persist = true){

        $user->generateOTP();
        if($persist) {
            $user->update(['otp', 'otp_expiration']);
        }
        event(new OTPGenerated($user));
    }


    public function attemptOTP($mobile, $otp){
        return User::where('mobile', $mobile)->where('otp', $otp)->where('otp_expiration', '>', time())->first();
    }


    public function get($attributes){
        return User::where($attributes)->get();
    }

    public function getOne($attributes){
        return User::where($attributes)->first();
    }
}