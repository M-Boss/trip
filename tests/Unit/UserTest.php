<?php
namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use \Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;


    protected function setUp(){
        parent::setUp();
    }


    public function testUserOTPGeneration()
    {
        $user = factory(User::class)->make();
        $user->generateOTP();
        $this->assertTrue(strlen($user->otp) > 1 && $user->otp_expiration > time());
    }


}