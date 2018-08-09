<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 7/31/18
 * Time: 5:15 PM
 */
namespace App\Repositories\Users;

interface Users{
    public function create($user);
    public function generateOTP($user);
    public function attemptOTP($mobile, $otp);
}