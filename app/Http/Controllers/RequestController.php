<?php

namespace App\Http\Controllers;

use \Grimzy\LaravelMysqlSpatial\Types\Point;
use App\Repositories\Requests\Requests;
use App\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{

    public function index(Requests $requestsRepo, \Illuminate\Http\Request $request){
        $r = new Request([
            'source' => new Point($request['source']['latitude'], $request['source']['longitude'])
        ]);

        $results = $requestsRepo->getMatchesFor($r);
        return ['requests' => $results];
    }
}
