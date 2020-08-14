<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Turn;
use Faker\Generator as Faker;

$factory->define(Turn::class, function (Faker $faker) {
    return [
        'turn_at' => $faker->unique()->time('H:i'),
        'active' => $faker->boolean
    ];
});
