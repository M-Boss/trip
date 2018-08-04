<?php
/**
 * Created by PhpStorm.
 * User: guy
 * Date: 7/31/18
 * Time: 5:15 PM
 */
namespace App\Repositories\Requests;

interface Requests{
    public function getMatchesFor($request);
    public function create($request);
}