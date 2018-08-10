<?php

namespace App\Listeners;

use App\Events\OTPGenerated;
use App\Services\ShortMessage\ShortMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOTPSMS
{

    private $sms;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ShortMessage $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Handle the event.
     *
     * @param  OTPGenerated  $event
     * @return void
     */
    public function handle(OTPGenerated $event)
    {
        $user = $event->user;
        $this->sms->send($user->mobile, 'Here\'s your login code: ' . $user->otp);
    }
}
