<?php

namespace Tests\Feature;

use App\Repositories\Requests\Requests;
use App\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use \Illuminate\Foundation\Testing\RefreshDatabase;

class RequestTest extends TestCase
{
    use RefreshDatabase;

    /** @var  \App\Repositories\Requests\Requests */
    protected  $requestsRepo;


    protected function setUp(){
        parent::setUp();
        $this->requestsRepo = $this->app->make(Requests::class);
    }


    public function testNearbyRequests()
    {
        //given I have one request stored in database
        $request = factory(Request::class)->make();
        $this->requestsRepo->create($request);

        //when I search for requests around that request location (1km distance max)
        $data = [
            'source' => [
                'latitude' => $request->source->getLat(),
                'longitude' => $request->source->getLng() + 0.01
            ],
            'at_time' => ''
        ];
        $response = $this->post('/api/requests', $data);

        //then I see one result
        $response->assertJsonCount(1, 'requests');
    }


    public function testRequestsOutOfRadiusShouldNotBeReturned()
    {
        //given I have one request stored in database
        $request = factory(Request::class)->make();
        $this->requestsRepo->create($request);

        //when I search for requests far from that request location (1km distance max)
        $data = [
            'source' => [
                'latitude' => $request->source->getLat(),
                'longitude' => $request->source->getLng() + 2
            ],
            'at_time' => ''
        ];
        $response = $this->post('/api/requests', $data);

        //then I see no results
        $response->assertJsonCount(0, 'requests');
    }
}


