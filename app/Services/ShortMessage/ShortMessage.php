<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 7/31/18
 * Time: 5:15 PM
 */
namespace App\Services\ShortMessage;

interface ShortMessage{
    public function send($number, $message);
}