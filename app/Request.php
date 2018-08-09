<?php

namespace App;

use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Request extends Model
{

    use SpatialTrait;
    public $spatialFields = ['source', 'destination', ];
    protected $fillable = ['source', 'destination', 'at_time', 'user_id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }
}
