<?php

use Faker\Generator as Faker;

$factory->define(\App\Request::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'source' => new \Grimzy\LaravelMysqlSpatial\Types\Point(35.7952, 51.4323),
        'destination' => new \Grimzy\LaravelMysqlSpatial\Types\Point(35.9952, 51.4323),
        'at_time' => time(),
        'empty_seats' => $faker->randomElement([1,2,3]),
        'female_only' => $faker->randomElement([0,1])
    ];
});
