<?php

namespace App\Http\Controllers;

use \Grimzy\LaravelMysqlSpatial\Types\Point;
use App\Repositories\Requests\Requests;
use App\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{

    public function index(Requests $requestsRepo, \Illuminate\Http\Request $httpRequest){
        $r = new Request([
            'source' => new Point($httpRequest['source']['latitude'], $httpRequest['source']['longitude']),
            'destination' => new Point($httpRequest['destination']['latitude'], $httpRequest['destination']['longitude']),
            'at_time' => $httpRequest['at_time'],
            'user_id' => 1
        ]);
        $results = $requestsRepo->getMatchesFor($r);
        if($httpRequest->get('save', false)){
            $requestsRepo->create($r);
        }
        return ['requests' => $results];
    }
}
