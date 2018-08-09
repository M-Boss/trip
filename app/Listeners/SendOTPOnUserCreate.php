<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Repositories\Users\Users;
use App\Services\ShortMessage\ShortMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOTPOnUserCreate
{

    private $sms;
    private $usersRepo;

    /**
     * Create the event listener.
     *
     * @param ShortMessage $sms
     * @param Users $usersRepo
     */
    public function __construct(ShortMessage $sms, Users $usersRepo)
    {
        $this->sms = $sms;
        $this->usersRepo = $usersRepo;
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $user = $event->user;
        $this->usersRepo->generateOTP($user);
        $this->sms->send($event->user->mobile, 'Here\'s your login code: ' . $user->otp);
    }
}
