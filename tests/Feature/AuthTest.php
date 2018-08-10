<?php
namespace Tests\Feature;

use App\Events\UserCreated;
use App\Listeners\SendOTPOnUserCreate;
use App\Repositories\Requests\Requests;
use App\Repositories\Users\Users;
use App\Request;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use \Illuminate\Foundation\Testing\RefreshDatabase;
use \Illuminate\Support\Facades\Event;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @var  \App\Repositories\Requests\Requests */
    protected  $requestsRepo;
    /** @var  Users */
    protected  $usersRepo;


    protected function setUp(){
        parent::setUp();
        $this->requestsRepo = $this->app->make(Requests::class);
        $this->usersRepo = $this->app->make(Users::class);
    }


    public function testUserSignup()
    {
        list($response, $data) = $this->registerUser();
        $response->assertStatus(200);
    }


    public function testUserCreatedEventDispatched(){
        Event::fake();

        list($response, $data) = $this->registerUser();
        Event::assertDispatched(UserCreated::class, function ($e) use ($data) {
            return $e->user->mobile === $data['mobile'];
        });
    }


    public function testUserCanLogInWithOTP(){
        $user = factory(User::class)->create();
        $this->usersRepo->generateOTP($user);

        $response = $this->post('api/auth/login', [
            'mobile' => $user->mobile,
            'otp' => $user->otp,
        ]);

        $response->assertStatus(200)
        ->assertSee('token');
    }


    public function testUserCantLoginWithWrongOTP(){
        $user = factory(User::class)->create();
        $this->usersRepo->generateOTP($user);

        $response = $this->post('api/auth/login', [
            'mobile' => $user->mobile,
            'otp' => 'jojo',
        ]);

        $response->assertStatus(401);
    }


    public function testNewOTPRequest(){
        $user = factory(User::class)->create();
        $response = $this->post('api/auth/otp', [
            'mobile' => $user->mobile
        ]);
        $response->assertStatus(200);
    }


    public function testNewOTPRequestUnregisteredNumberShouldSucceed(){

        $response = $this->post('api/auth/otp', [
            'mobile' => '09121122323'
        ]);
        $response->assertStatus(200);
    }


    private function registerUser(){
        $data = [
            'mobile' => '09111777052',
            'password' => '12345',
            'name' => 'Guy',
        ];
        return [$this->post('/api/auth/register', $data), $data];
    }

}