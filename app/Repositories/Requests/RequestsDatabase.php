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
        $r =  Request::distanceSphere('source', $request->source, $distance)->get();
        return $r;
    }
}