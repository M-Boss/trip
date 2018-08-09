<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 7/31/18
 * Time: 5:15 PM
 */
namespace App\Services\ShortMessage;

use Illuminate\Support\Facades\Log;


class ShortMessageFile implements ShortMessage {

    public function send($number, $message){
        Log::debug("sms to $number: $message");
    }
}