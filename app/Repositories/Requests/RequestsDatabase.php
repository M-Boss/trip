<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 7/31/18
 * Time: 5:15 PM
 */
namespace App\Repositories\Requests;

use App\Request;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class RequestsDatabase implements Requests {

    public function create($request){
        $request->save();
    }


    public function getMatchesFor($request, $distance = 1000){
        $deltaTime = config('logic.delta_time'); //seconds

        $query = Request::whereBetween('at_time', [$request->at_time - $deltaTime, $request->at_time + $deltaTime])
            ->distanceSphere('source', $request->source, $distance);

        $r =  $query->get();
        return $r;
    }
}