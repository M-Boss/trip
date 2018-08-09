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


    private function createSingleRequest(){
        $request = factory(Request::class)->make();
        $this->requestsRepo->create($request);
        return $request;
    }


    public function testNearbyRequests()
    {
        //given I have one request stored in database
        $request = $this->createSingleRequest();

        //when I search for requests around that request location (1km distance max)
        $data = [
            'source' => [
                'latitude' => $request->source->getLat(),
                'longitude' => $request->source->getLng() + 0.01
            ],
            'at_time' => $request->at_time
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


    public function testRequestsWithTimeDistaneShouldNotBeMatched()
    {
        //given I have one request stored in database
        $request = $this->createSingleRequest();

        //when I search for requests around that request location (1km distance max)
        $data = [
            'source' => [
                'latitude' => $request->source->getLat(),
                'longitude' => $request->source->getLng() + 0.01
            ],
            'at_time' => $request->at_time + config('logic.delta_time') + 30
        ];
        $response = $this->post('/api/requests', $data);
        //then I see one result
        $response->assertJsonCount(0, 'requests');
    }


    public function testSaveRequestSoOthersCanFindIt()
    {
        //given I have no request stored in database

        //when I search with 'save' flag set to true
        $data = $this->createQuery();

        $this->post('/api/requests', $data);
        //then I have one record in database
        $data['user_id'] = 2;
        $response = $this->post('/api/requests', $data);
        $response->assertJsonCount(1, 'requests');
    }


    private function createQuery(){
        return [
            'destination' => [
                'latitude' => 30.7,
                'longitude' => 40.1
            ],
            'source' => [
                'latitude' => 30,
                'longitude' => 40
            ],
            'at_time' => time(),
            'user_id' => 1,
            'save' => true
        ];
    }
}