<?php

/**
 * Created by PhpStorm.
 * User: guy
 * Date: 8/10/18
 * Time: 1:27 AM
 */
namespace App\Services;

class Helpers
{

    public static function generateOTP(){
        return str_random(6);
    }
}